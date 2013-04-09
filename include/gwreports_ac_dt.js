
	var jq = [	gwrpt_jqurl+'jquery-1.9.1.js' ];
	var jqui = [ gwrpt_jqurl+'ui/jquery-ui.custom.js',
				gwrpt_jqurl+'ui/jquery.dataTables.js'];

	var jqcss = [ gwrpt_jqurl+'themes/base/jquery.ui.all.css',
				gwrpt_jqurl+'themes/base/jquery.dataTables.css'];

	function gwreportsIncludeJs(array,callback){
		var loader = function(src,handler){
			var done=false;
			var script = document.createElement("script");
			script.src = src;
			script.onload = script.onreadystatechange = function () {
					if ( !done && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") ) {
						done = true;
						handler(); //execute
					}
			};
			document.getElementsByTagName("head")[0].appendChild(script);
		};
		var handler = function(){
			if(array.length!=0){
				loader(array.shift(),handler);
			}else{
				callback && callback();
			}
		};
		handler();
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
if (typeof(window.gwreportsACActivated) == 'undefined') { 
	var $ourjq=null;
	gwreportsIncludeJs(jq.concat(jqui), function(){ 
			gwreportsIncludeStyle(jqcss);
			$(document).ready(function(){
				if($ourjq==null) $ourjq = jQuery.noConflict(true);
				gwreportsActivateAutoComplete();
			}); 
		});
}


