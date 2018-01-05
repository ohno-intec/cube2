
/*
*
* Common
*
*/

//datapicker
$( function() {
	$( ".datepicker" ).datepicker({
		dateFormat: "yy/mm/dd"
	});
} );

//add_selected
function add_selected($selectName, $setting) {
	$(function(){
		$("select[name="+$selectName+"]").val($setting);
	});
}

//add_checked
function add_checked($inputName, $setting) {
	$(function(){
		$("input[name="+$inputName+"]").val([$setting]);
	});
}



/*
*
* masters
*
*/
//create
//productname

$( function() {
	//select[brand_id]がチェンジされたらtext[product_name]のvalueを書き換え
	$("select[name=brand_id]").change(function(){
		if($("select[name=brand_id]").prop("selectedIndex") !== 0){
			$brand_name = $("select[name=brand_id] option:selected").text();
		}else{
			$brand_name = "";
		}
		$product_modelnumber = $("input[name=product_modelnumber]").val();

		$product_name = $brand_name + " " + $product_modelnumber
		$product_name = $product_name.substr(0,36);

		$("input[name=product_name]").val($product_name);
	});

	$("input[name=product_modelnumber]").keyup(function(){
		$product_modelnumber = $(this).val();

		$select_brandid = $("select[name=brand_id]").prop("selectedIndex");
		console.log($select_brandid);

		if($select_brandid !== 0 && $select_brandid !== undefined){
			$brand_name = $("select[name=brand_id] option:selected").text();
		}else if($("#brand_name").attr('type') === 'text'){
			$brand_name = $("#brand_name").val();
		}else{
			$brand_name = "";
		}

		$product_name = $brand_name + " " + $product_modelnumber
		$product_name = $product_name.substr(0,36);

		$('input[name=product_name]').val($product_name);

	});

});

//productindex

$( function(){
	$("input[name=product_modelnumber]").keyup(function(){
		$product_index = $(this).val().toLowerCase();
		$product_index = $product_index.substr(0,10);
		$('input[name=product_index').val($product_index);
	});
});

//tooltip
//Bootstrapのツールチップに変更
/*
function tooltip(){
	$(function(){
		$body = $("body");
		//各　.my-tooltip要素に対して処理
		$(".my-tooltip").each(function(){
			$this_tooltip = $(this);
			title = $this_tooltip.attr("title");
			//ツールチップ本体を生成
			$tooltip = $([
				"<span class='tooltip'>",
					"<span class='tooltip__body'>",
						title,
					"</span>",
				"</span>"
				].join(""));

			//イベントの設定
			$this_tooltip.mouseenter(function(){
				//<body>へツールチップを追加
				$body.append($tooltip);
				//要素の表示位置
				var offset = $this_tooltip.offset();
				//要素のサイズ
				var size = {
					width:$this_tooltip.outerWidth(),
					height:$this_tooltip.outerHeight()
				}
				var ttSize = {
					width:$tooltip.outerWidth(),
					height:$tooltip.outerHeight()
				}
				//要素の上に横中央で配置
				$tooltip.css({
					top: offset.top - ttSize.height,
					left: offset.left + size.width / 2 -ttSize.width / 2
				});
			}).mouseleave(function(){
				//$tooltip.remove();
			});
		});

	});
}*/


$(function(){
	$('#smileAllCheck_button').on('click', function(){
		$('.smileCheck').each(function(){
			$(this).prop('checked', true);
		});
	});
});

