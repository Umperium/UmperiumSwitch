<style>
    [placeholder]:empty::before {
        content: attr(placeholder);
        color: #555;
    }

    [placeholder]:empty:focus::before {
        content: "";
    }
</style>
<div class="card card-body">

    <div class="row">
        <div class="col-sm-10 mx-auto ">
            <h1 class="name" id="name" contenteditable="true" placeholder="Заголовок"><?php echo $row['name']; ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10 mx-auto">
            <div id="codex-editor"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10 mx-auto mb-3">
            <select class="form-control" id="access_id">
                <option value="0" <?php echo $row['access_id'] == 0 ? "selected" : ""; ?>>Виден всем</option>
                <option value="1" <?php echo $row['access_id'] == 1 ? "selected" : ""; ?>>Виден подписчикам</option>
                <option value="2" <?php echo $row['access_id'] == 2 ? "selected" : ""; ?>>Платные просмотры</option>
            </select>
        </div>
    </div>

    <div class="row" id="price-wrapper" style="display: <?php echo $row['access_id'] == 2 ? "block" : "none"; ?>">
        <div class="col-sm-10 mx-auto mb-3">
            <input class="form-control" type="number" name="price" value="<?php echo $row['price']; ?>" id="price">
        </div>
    </div>


    <div class="row">
        <div class="col-sm-10 mx-auto mb-3">
            <input class="form-control" type="text" name="tag" value="<?php echo $tag_list; ?>" id="tag"
                   placeholder="Теги: через пробел">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-10 mx-auto">
            <button name="edit" id="edit" type="submit" value="true" class="btn btn-primary waves-effect waves-light">
                Сохранить
            </button>
        </div>
    </div>

</div>


<?php
// !!
function html_to_obj($html)
{
    $dom = new DOMDocument();
    $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");
    $dom->loadHTML($html);
    return element_to_obj($dom->documentElement);
}

function element_to_obj($element)
{
    $obj = array("tag" => $element->tagName);
    foreach ($element->attributes as $attribute) {
        $obj[$attribute->name] = $attribute->value;
    }
    foreach ($element->childNodes as $subElement) {
        if ($subElement->nodeType == XML_TEXT_NODE) {
            $obj["html"] = $subElement->wholeText;
        } else {
            $obj["children"][] = element_to_obj($subElement);
        }
    }
    return $obj;
}


$json = json_encode(html_to_obj($row['content']));
$json_obj = json_decode($json, JSON_UNESCAPED_UNICODE);

$requestData = array();
foreach ($json_obj as $key => $item) {
    $requestData[$key] = $item;
}

$new_json = '';

$rowData = array();
foreach ($requestData["children"] as $key => $item) {
    $rowData[$key] = $item;
}

for ($i = 0; $i < count($rowData); $i++) {

    $includeData = array();
    foreach ($rowData[$i] as $key => $item) {
        $includeData[$key] = $item;
    }

    $childrenData = array();
    foreach ($includeData["children"] as $key => $item) {
        $childrenData[$key] = $item;
    }

    for ($i = 0; $i < count($childrenData); $i++) {

        $tagData = array();
        foreach ($childrenData[$i] as $key => $item) {
            $tagData[$key] = $item;
        }

        if ($tagData['tag'] == 'p') {
            $new_json .= ' {"type" : "paragraph", "data" : { "text" : "' . $tagData['html'] . '" } },';
        }
        if ($tagData['tag'] == 'ul') {

            $liData = array();
            foreach ($tagData["children"] as $key => $item) {
                $liData[$key] = $item;
            }

            $liArr = array();
            for ($j = 0; $j < count($liData); $j++) {
                $tagsliData = array();
                foreach ($liData[$j] as $key => $item) {
                    $tagsliData[$key] = $item;
                }
                $liArr[] = '"' . $tagsliData['html'] . '"';
            }

            $new_json .= '  {"type" : "list","data" : { "style" : "unordered","items" : [' . implode(',', $liArr) . ']}},';
        }

        if ($tagData['tag'] == 'h2') {
            $new_json .= ' {"type" : "header", "data" : { "text" : "' . $tagData['html'] . '", "level" : 2 } },';
        }

        if ($tagData['tag'] == 'img') {
            if (trim($tagData['src']) == '') continue;
            $new_json .= ' {"type" : "image", "data" : { "file": { "url" : "' . $tagData['src'] . '" } } },';
        }

        if ($tagData['tag'] == 'blockquote') {
            $new_json .= ' {"type" : "quote", "data" : {  "text" : "' . $tagData['html'] . '", "alignment" : "left" } },';
        }
    }
}


?>

<style>
    {
        border-bottom: 1px dashed #000
    }
</style>
<script src="/assets/plugins/editorjs/editor.js"></script>
<script src="/assets/plugins/editorjs/header.js"></script>
<script src="/assets/plugins/editorjs/list.js"></script>
<script src="/assets/plugins/editorjs/image.js"></script>
<script src="/assets/plugins/editorjs/link.js"></script>
<script src="/assets/plugins/editorjs/quote.js"></script>
<script src="/assets/plugins/editorjs/gallery.js"></script>
<script>
    "use strict";
    const ImageTool = window.ImageTool;
    $(document).ready(function () {
        try {


            $("#access_id").change(function () {
                if ($(this).val() == 2) {
                    $("#price-wrapper").show();
                } else {
                    $("#price-wrapper").hide();
                }
            });


            // Check if button is active.
            var isActive = function (cmd) {
                var blocks = this.selection.blocks();

                if (blocks.length) {
                    var blk = blocks[0];
                    var tag = 'N';
                    var default_tag = this.html.defaultTag();
                    if (blk.tagName.toLowerCase() != default_tag && blk != this.el) {
                        tag = blk.tagName;
                    }
                }

                if (['LI', 'TD', 'TH'].indexOf(tag) >= 0) {
                    tag = 'N';
                }

                return tag.toLowerCase() == cmd;
            }

            var editor = new EditorJS({
                holder: 'codex-editor',
                tools: {
                    header: {
                        class: Header,
                        config: {
                            placeholder: "Заголовок"
                        }
                    },
                    gallery: {
                        class: GalleryTool,
                        config: {
                            endpoints: {
                                byFile: '/post/upload/image',
                                byUrl: '/post/upload/imageurl'
                            }
                        }
                    },
                    list: List,
                    linkTool: LinkTool,
                    image: {
                        class: ImageTool,
                        config: {
                            endpoints: {
                                byFile: '/post/upload/image',
                                byUrl: '/post/upload/imageurl'
                            }
                        }
                    },
                    quote: Quote
                },


                data: {
                    blocks: [
                        <?php echo $new_json; ?>
                    ]
                }
            });

            function emulatePlusAction() {
                if ($(document).find("img.image-tool__image-picture").last().attr('src') !== null &&
                    $(document).find("img.image-tool__image-picture").last().attr('src') !== undefined &&
                    $(document).find("img.image-tool__image-picture").last().attr('src') !== '') {
                    setTimeout(function () {
                        $(document).find("img.image-tool__image-picture").last().click();
                        setTimeout(function () {
                            const ke = new KeyboardEvent("keydown", {
                                bubbles: true,
                                cancelable: true,
                                keyCode: 13
                            });
                            document.body.dispatchEvent(ke);
                            setTimeout(function () {
                                $("div.ce-toolbar__plus").click();
                            }, 2000);
                        }, 2000);
                    }, 1000);
                } else {
                    setTimeout(function () {
                        emulatePlusAction();
                    })
                }
            }

            $(window).load(function () {
                //$("li[data-tool='image']").after('<li class="ce-toolbox__button" data-tool="gallery"><img src="/../assets/images/gallery.svg" width="22" height="22" style="opacity:0.7"></li>');
                setTimeout(function () {

                    emulatePlusAction();
                    $(document.body).on("DOMNodeInserted", "img", function () {
                        emulatePlusAction();
                    })
                }, 1000);
            });


            $(document.body).on("DOMNodeInserted", "div.codex-editor", function () {
                if ($(this).find("div.cdx-input.image-tool__caption").length !== 0) {
                    $(this).find("div.cdx-input.image-tool__caption").css("display", "none");
                }
            });


            $("body").on("click", "#edit", function () {


                if ($("#name").text() === '') {
                    alert("Insert post name");
                    $("#name").focus();
                    return false;
                }
                editor.save().then((outputData) => {
                    let postParams = {};
                    postParams.name = $("#name").text();
                    postParams.edit = $("#edit").val();
                    postParams.access_id = $("#access_id").val();
                    postParams.price = $("#price").val();
                    postParams.tag = $("#tag").val();
                    postParams.content = outputData;

                    $.ajax({
                        type: "POST",
                        url: '/post/edit/<?php echo $row['id']; ?>',
                        data: postParams,
                        success: function (data) {
                            window.location.replace("/post/" + data);
                        }
                    });

                });

                return false;
            });

        } catch (e) {
            alert('Ошибка ' + e.name + ": " + e.message + "\n" + e.stack);
        }

    });
</script>