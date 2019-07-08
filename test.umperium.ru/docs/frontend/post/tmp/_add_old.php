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
		<div class="col-sm-10 mx-auto">
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
			tools: {
                header: {
									class: Header,
									config: {
										placeholder: "Заголовок"
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
            }
		});

		document.getElementById("name").addEventListener("keypress", (e) => {
            if (e.keyCode == 13) {
                e.preventDefault();
                editor.caret.focus();
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
				postParams.tag = $("#price").val();
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