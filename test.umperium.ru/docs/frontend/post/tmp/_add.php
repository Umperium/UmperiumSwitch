<style>
[placeholder]:empty::before {
    content: attr(placeholder);
    color: #555; 
}

[placeholder]:empty:focus::before {
    content: "";
}
#name, #price, #tag, #add, #access_id, #div_add, #tip {
	margin-top: 0px;
  margin-right: auto;
  margin-bottom: 0px;
  margin-left: auto;
  max-width: 650px;
}

 .cdx-quote__caption{
	display:none ;
}
</style>
<div class="card card-body">


	<div class="row">
		<div class="col-sm-10 mx-auto ">
			<h1 class="name" id="name" contenteditable="true" placeholder="Заголовок"></h1>
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
				<option value="0">Виден всем</option>
				<option value="1">Виден подписчикам</option>
				<option value="2">Платные просмотры</option>
			</select>
		</div>
	</div>
	
	<div class="row" id="price-wrapper" style="display: none"> 
		<div class="col-sm-10 mx-auto mb-3">
        	<input class="form-control" type="number" name="price" value="0" id="price">
		</div>
	</div>
	
	<div class="row" > 
		<div class="col-sm-10 mx-auto mb-3">
        	<input class="form-control" type="text" name="tag" value="" id="tag" placeholder="Теги: через пробел">
		</div>
	</div>
	
	<div class="row"> 
		<div class="col-sm-10 mx-auto" id="div_add">
			<button name="add" id="add" type="submit" value="true" class="btn btn-primary waves-effect waves-light">Сохранить</button>
		</div>
	</div>
	
</div>
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
$(document).ready(function() {
	try{ 
		
			
		$("#access_id").change(function(){
			if($(this).val() == 2) {
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
			minHeight: -200,
			tools: {
								image: {
									class: ImageTool,
									config: {
										endpoints: {
											byFile: '/post/upload/image',
											byUrl: '/post/upload/imageurl'
										}
					// 					uploader: {
          // /**
          //  * Upload file to the server and return an uploaded image data
          //  * @param {File} file - file selected from the device or pasted by drag-n-drop
          //  * @return {Promise.<{success, file: {url}}>}
          //  */
          // uploadByFile(file){
          //   // your own uploading logic here
          //   return MyAjax.upload(file).then(() => {
          //     return {
          //       success: 1,
          //       file: {
          //         url: 'https://codex.so/upload/redactor_images/o_80beea670e49f04931ce9e3b2122ac70.jpg',
          //         // any other image data you want to store, such as width, height, color, extension, etc
          //       }
          //     };
          //   });
          // },
          
          // /**
          //  * Send URL-string to the server. Backend should load image by this URL and return an uploaded image data
          //  * @param {string} url - pasted image URL
          //  * @return {Promise.<{success, file: {url}}>}
          //  */
          // uploadByUrl(url){
          //   // your ajax request for uploading
          //   return MyAjax.upload(file).then(() => {
          //     return {
          //       success: 1,
          //       file: {
          //         url: 'https://codex.so/upload/redactor_images/o_e48549d1855c7fc1807308dd14990126.jpg',
          //         // any other image data you want to store, such as width, height, color, extension, etc
          //       }
          //     }
          //   })
          // }
					// 				}
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
								quote: Quote,
                header: {
									class: Header,
									config: {
										placeholder: "Заголовок"
									}
								},                
                linkTool: LinkTool                
            }
		});

		function emulatePlusAction(){
				if($(document).find("img.image-tool__image-picture").last().attr('src')!==null && 
				$(document).find("img.image-tool__image-picture").last().attr('src')!==undefined &&
				$(document).find("img.image-tool__image-picture").last().attr('src')!==''){
				setTimeout(function() {
							$(document).find("img.image-tool__image-picture").last().click();
							setTimeout(function() {
								const ke = new KeyboardEvent("keydown", {
									bubbles: true,
									cancelable: true,
									keyCode: 13
								});
								document.body.dispatchEvent(ke);
								setTimeout(function() {
									$("div.ce-toolbar__plus").click();
								}, 2000);
							}, 2000);
						}, 1000);
					}
					else{
						setTimeout(function(){
							emulatePlusAction();
						})
					}
			}
		
			$(window).load(function() {
				// $("li[data-tool='image']").after('<li class="ce-toolbox__button" data-tool="gallery"><img src="/../assets/images/gallery.svg" width="22" height="22" style="opacity:0.7"></li>');
				
				setTimeout(function() {
          $('.ce-paragraph.cdx-block').click()
					setTimeout(function() {
									$("div.ce-toolbar__plus").click();
								}, 2000);
					$(document.body).on("DOMNodeInserted", "img", function() {
						emulatePlusAction();
										})			
				}, 1000);	
			});


			$(document.body).on("DOMNodeInserted", "div.codex-editor", function() {
				if ($(this).find("div.cdx-input.image-tool__caption").length !== 0) {
					$(this).find("div.cdx-input.image-tool__caption").css("display", "none");
				}
			});
		
		
		$( "body" ).on( "click", "#add", function() {
		    
		    if($("#name").text() === '') { 
				alert("Insert post name"); 
				$("#name").focus(); 
				return false; 
			}
			editor.save().then((outputData) => {
				let postParams = {};
				postParams.name = $("#name").text();
				postParams.add = $("#add").val();
				postParams.access_id = $("#access_id").val();
				postParams.price = $("#price").val();
				postParams.tag = $("#tag").val();
				postParams.repost_id = <?php echo $_GET['repost_id']?$_GET['repost_id']:0; ?>;
				postParams.content = outputData;
							
				$.ajax({
					type: "POST",
					url: '/post/add',
					data: postParams,
					success: function(data){
						window.location.replace("/post/" + data);
					}
				});

			});			
			return false;
		});

	} catch(e) { 
		alert('Ошибка ' + e.name + ": " + e.message + "\n" + e.stack);
	}
	
});

 
</script>