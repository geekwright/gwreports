if (typeof(window.gwreportsACActivated) == 'undefined') {  

	var jq = [	gwrpt_jqurl+'jquery-1.9.1.js',
				gwrpt_jqurl+'ui/jquery-ui.custom.js',
				gwrpt_jqurl+'ui/jquery.dataTables.js'];

	var jqcss = [ gwrpt_jqurl+'themes/base/jquery.ui.all.css',
				gwrpt_jqurl+'themes/base/jquery.dataTables.css'];

	function gwreportsIncludeJs(array,callback){
		var loader = function(src,handler){
			var script = document.createElement("script");
				script.src = src;
				script.onload = script.onreadystatechange = function(){
					script.onreadystatechange = script.onload = null;
					handler();
				}
			var head = document.getElementsByTagName("head")[0];
			(head || document.body).appendChild( script );
		};
		(function(){
			if(array.length!=0){
				loader(array.shift(),arguments.callee);
			}else{
				callback && callback();
			}
		})();
	}

	function gwreportsIncludeStyle(cssFilePath) {
		for (var i = 0; i < cssFilePath.length; i++) {
			var css = document.createElement("link");
			css.type = "text/css";
			css.rel = "stylesheet";
			css.href = cssFilePath[i];
			document.body.appendChild(css);
		};
	}

	function gwreportsActivateAutoComplete(){
		if (window.gwreportsACActivated==true) return;
		
		try {
			$ourjq(".autocomplete").each(function(index){
				link=$ourjq(this).attr('autocompleteurl');
				$ourjq(this).autocomplete({
					source:link,
					minLength: 2,
					delay: 400,
					autoFocus:true,		
//					select: function( event, ui ) {				
//						$ourjq(this).change();
//					}
				});
			});
		}
		catch(err) { 
			return;
		}
		try {
			$ourjq(".dataTable").each(function(){
				$ourjq(this).dataTable( {
					"aaSorting": [],
					"iDisplayLength": 15,
					"aLengthMenu": [[15, 50, 100, -1], [15, 50, 100, gwrpt_lang_all]],
					"sPaginationType": "full_numbers",
					"oLanguage": {
						"sLengthMenu": gwrpt_lang_slengthmenu,
						"sSearch": gwrpt_lang_ssearch,
						"sInfo": gwrpt_lang_sinfo,
						"sInfoEmpty": gwrpt_lang_sinfoempty,
						"sInfoFiltered": gwrpt_lang_sinfofiltered,
						"sEmptyTable": gwrpt_lang_semptytable,
						"sZeroRecords": gwrpt_lang_szerorecords,
						"oPaginate": {
							"sNext": gwrpt_lang_snext,
							"sPrevious": gwrpt_lang_sprevious,
							"sFirst": gwrpt_lang_sfirst,
							"sLast": gwrpt_lang_slast
						}
					}
				});
			});
		}
		catch(err) { 
			return;
		}

		window.gwreportsACActivated=true;
	}

//	window.onload = function() {
//		gwreportsActivateAutoComplete();
//	};
	var $ourjq=null;
	gwreportsIncludeJs(jq, function(){ 
			gwreportsIncludeStyle(jqcss);
			$(document).ready(function(){
				if($ourjq==null) $ourjq = jQuery.noConflict(true);
				gwreportsActivateAutoComplete();
			}); 
		});
}


