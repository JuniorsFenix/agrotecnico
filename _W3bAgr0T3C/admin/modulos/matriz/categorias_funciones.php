<?php include("../../funciones_generales.php");
  	function CategoriasForm($nId=0) {
    $IdCiudad = $_SESSION["IdCiudad"];
?>
	<style>
		
		.activeDroppable {
			background-color: #eeffee;
		}

		.hoverDroppable {
			background-color: lightgreen;
		}

		.draggableField {
			/* float: left; */
			padding-left:5px;
			overflow:hidden;
		}
		
		.btn-content {
			float: right;
		}
		
		.draggableField > input,select, button, .checkboxgroup, .selectmultiple, .radiogroup {
			margin-top: 10px;
			
			margin-right: 10px;
			margin-bottom: 10px;
		}

		.draggableField:hover{
			background-color: #ccffcc;
		}
	</style>
	
	<style id="content-styles">
		/* Styles that are also copied for Preview */
		body {
			margin: 10px 0 0 10px;
		}
		
		.control-label {
			display: inline-block !important;
			pasdding-top: 5px;
			text-align: right;
			vertical-align: baseline;
			padding-right: 10px;
		}
		
		.droppedField {
			padding-left:5px;
		}

		.droppedField > input,select, button, .checkboxgroup, .selectmultiple, .radiogroup {
			margin-top: 10px;
			
			margin-right: 10px;
			margin-bottom: 10px;
		}

		.action-bar .droppedField {
			float: left;
			padding-left:5px;
		}

	</style>
<script>
	/* Make the control draggable */
	function makeDraggable() {
		$(".selectorField").draggable({ helper: "clone",stack: "div",cursor: "move", cancel: null  });
	}
	var _ctrl_index = 1001;
	function docReady() {
		var tipo=$("#tipo").val();
		var id=$("#txtId").val();
		var dataString = 'tipo='+ tipo;
		var dataString2 = {tipo:tipo,id:id};
		$.ajax({
			type: "POST",
			url: "ajax_campos.php",
			data: dataString,
			cache: false,
			success: function(html){
				$("#listOfFields").html(html);
				makeDraggable();
			}
		});
		$.ajax({
			type: "POST",
			url: "ajax_campos2.php",
			data: dataString2,
			cache: false,
			success: function(html){
				$("#selected-column-1").html(html);
				makeDraggable();
				$( ".droppedField" ).each(function() {
				_ctrl_index = this.id;
				_ctrl_index++;
				});
			}
		});
		if (tipo == 1) {
			$("#categoria").prop('disabled', false);
		}
		else{
			$("#categoria").prop('disabled', true);
		}
		
		$("#tipo").change(function(){
			var tipo=$(this).val();
			var dataString = 'tipo='+ tipo;
			var dataString2 = {tipo:tipo,id:id};
			$.ajax({
				type: "POST",
				url: "ajax_campos.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#listOfFields").html(html);
					makeDraggable();
				} 
			});
			$.ajax({
				type: "POST",
				url: "ajax_campos2.php",
				data: dataString2,
				cache: false,
				success: function(html){
					$("#selected-column-1").html(html);
					makeDraggable();
					$( ".droppedField" ).each(function() {
					_ctrl_index = this.id;
					_ctrl_index++;
					});
				}
			});
			if (tipo == 1) {
				$("#categoria").prop('disabled', false);
			}
			else{
				$("#categoria").prop('disabled', true);
				}
			compileTemplates(tipo);
		});
		$('#save').click(function (e) {
			//e.preventDefault();
				$( "input[type='checkbox']" ).each(function() {
					$(this).prop('checked', true);
				});
				$( "input[type='radio']" ).each(function() {
					$(this).prop('checked', true);
				});
				$('#guardarForm select option').prop('selected', true);
		});
		console.log("document ready");
		compileTemplates(tipo);
		
	$( ".droppedField" ).each(function() {
	_ctrl_index = this.id;
	_ctrl_index++;
	});
	$('body').on('click', '.droppedField', function() {
		var tipo=$("#tipo").val();
		if (tipo == 2) {
			var me = $(this)
			var ctrl = me.find("[class*=ctrl]")[0];
			var ctrl_type = $.trim(ctrl.className.match("ctrl-.*")[0].split(" ")[0].split("-")[1]);
			customize_ctrl(ctrl_type, this.id);
			//window["customize_"+ctrl_type](this.id);
		}
				});
		makeDraggable();
		
		$( ".droppedFields" ).droppable({
			  activeClass: "activeDroppable",
			  hoverClass: "hoverDroppable",
			  accept: function(draggable) {
       		 var uiIndex = draggable.attr('data-index');
				return $(this).find('[data-index=' + uiIndex + ']').length == 0;
			  },
			  drop: function( event, ui ) {
				//console.log(event, ui);
				var draggable = ui.draggable;				
				draggable = draggable.clone();
				draggable.removeClass("selectorField");
				draggable.addClass("droppedField"); 
				draggable[0].id = (_ctrl_index++); // Attach an ID to the rendered control
				draggable.appendTo(this);

				makeDraggable();
			}
		});		

		/* Make the droppedFields sortable and connected with other droppedFields containers*/
		$( ".droppedFields" ).sortable({
			cancel: null, // Cancel the default events on the controls
			connectWith: ".droppedFields"
		}).disableSelection();
	}
	
	
	/* Delete the control from the form */
	function delete_ctrl() {
		if(window.confirm("Are you sure about this?")) {
			var ctrl_id = $("#theForm").find("[name=forCtrl]").val()
			console.log(ctrl_id);
			$("#"+ctrl_id).remove();
		}
	}
	
	$('body').on('click', '.btn-content', function(e) {
			e.preventDefault();
		if(window.confirm("Are you sure about this?")) {
			var ctrl_id = $(this).parent().attr('id');
			console.log(ctrl_id);
			$("#"+ctrl_id).remove();
		}
	});
	
	/* Compile the templates for use */
	function compileTemplates(tipo) {
		window.templates = {};
		if (tipo == 1) {
			window.templates.common = Handlebars.compile($("#control-customize-content").html());
		}
		else{
			window.templates.common = Handlebars.compile($("#control-customize-form").html());
		}
		
		
		/* HTML Templates required for specific implementations mentioned below */
		
		// Mostly we donot need so many templates
		
		/*window.templates.textbox = Handlebars.compile($("#textbox-template").html());
		window.templates.passwordbox = Handlebars.compile($("#textbox-template").html());*/
		window.templates.combobox = Handlebars.compile($("#combobox-template").html());
		window.templates.selectmultiplelist = Handlebars.compile($("#combobox-template").html());
		window.templates.radiogroup = Handlebars.compile($("#combobox-template").html());
		window.templates.checkboxgroup = Handlebars.compile($("#combobox-template").html());
		//window.templates.textarea = Handlebars.compile($("#textbox-template").html());
		
	}
	
	function removeDiacritics(str) {
	
		var defaultDiacriticsRemovalMap = [
			{'base':'A', 'letters':/[\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F]/g},
			{'base':'AA','letters':/[\uA732]/g},
			{'base':'AE','letters':/[\u00C6\u01FC\u01E2]/g},
			{'base':'AO','letters':/[\uA734]/g},
			{'base':'AU','letters':/[\uA736]/g},
			{'base':'AV','letters':/[\uA738\uA73A]/g},
			{'base':'AY','letters':/[\uA73C]/g},
			{'base':'B', 'letters':/[\u0042\u24B7\uFF22\u1E02\u1E04\u1E06\u0243\u0182\u0181]/g},
			{'base':'C', 'letters':/[\u0043\u24B8\uFF23\u0106\u0108\u010A\u010C\u00C7\u1E08\u0187\u023B\uA73E]/g},
			{'base':'D', 'letters':/[\u0044\u24B9\uFF24\u1E0A\u010E\u1E0C\u1E10\u1E12\u1E0E\u0110\u018B\u018A\u0189\uA779]/g},
			{'base':'DZ','letters':/[\u01F1\u01C4]/g},
			{'base':'Dz','letters':/[\u01F2\u01C5]/g},
			{'base':'E', 'letters':/[\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E]/g},
			{'base':'F', 'letters':/[\u0046\u24BB\uFF26\u1E1E\u0191\uA77B]/g},
			{'base':'G', 'letters':/[\u0047\u24BC\uFF27\u01F4\u011C\u1E20\u011E\u0120\u01E6\u0122\u01E4\u0193\uA7A0\uA77D\uA77E]/g},
			{'base':'H', 'letters':/[\u0048\u24BD\uFF28\u0124\u1E22\u1E26\u021E\u1E24\u1E28\u1E2A\u0126\u2C67\u2C75\uA78D]/g},
			{'base':'I', 'letters':/[\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197]/g},
			{'base':'J', 'letters':/[\u004A\u24BF\uFF2A\u0134\u0248]/g},
			{'base':'K', 'letters':/[\u004B\u24C0\uFF2B\u1E30\u01E8\u1E32\u0136\u1E34\u0198\u2C69\uA740\uA742\uA744\uA7A2]/g},
			{'base':'L', 'letters':/[\u004C\u24C1\uFF2C\u013F\u0139\u013D\u1E36\u1E38\u013B\u1E3C\u1E3A\u0141\u023D\u2C62\u2C60\uA748\uA746\uA780]/g},
			{'base':'LJ','letters':/[\u01C7]/g},
			{'base':'Lj','letters':/[\u01C8]/g},
			{'base':'M', 'letters':/[\u004D\u24C2\uFF2D\u1E3E\u1E40\u1E42\u2C6E\u019C]/g},
			{'base':'N', 'letters':/[\u004E\u24C3\uFF2E\u01F8\u0143\u00D1\u1E44\u0147\u1E46\u0145\u1E4A\u1E48\u0220\u019D\uA790\uA7A4]/g},
			{'base':'NJ','letters':/[\u01CA]/g},
			{'base':'Nj','letters':/[\u01CB]/g},
			{'base':'O', 'letters':/[\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C]/g},
			{'base':'OI','letters':/[\u01A2]/g},
			{'base':'OO','letters':/[\uA74E]/g},
			{'base':'OU','letters':/[\u0222]/g},
			{'base':'P', 'letters':/[\u0050\u24C5\uFF30\u1E54\u1E56\u01A4\u2C63\uA750\uA752\uA754]/g},
			{'base':'Q', 'letters':/[\u0051\u24C6\uFF31\uA756\uA758\u024A]/g},
			{'base':'R', 'letters':/[\u0052\u24C7\uFF32\u0154\u1E58\u0158\u0210\u0212\u1E5A\u1E5C\u0156\u1E5E\u024C\u2C64\uA75A\uA7A6\uA782]/g},
			{'base':'S', 'letters':/[\u0053\u24C8\uFF33\u1E9E\u015A\u1E64\u015C\u1E60\u0160\u1E66\u1E62\u1E68\u0218\u015E\u2C7E\uA7A8\uA784]/g},
			{'base':'T', 'letters':/[\u0054\u24C9\uFF34\u1E6A\u0164\u1E6C\u021A\u0162\u1E70\u1E6E\u0166\u01AC\u01AE\u023E\uA786]/g},
			{'base':'TZ','letters':/[\uA728]/g},
			{'base':'U', 'letters':/[\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244]/g},
			{'base':'V', 'letters':/[\u0056\u24CB\uFF36\u1E7C\u1E7E\u01B2\uA75E\u0245]/g},
			{'base':'VY','letters':/[\uA760]/g},
			{'base':'W', 'letters':/[\u0057\u24CC\uFF37\u1E80\u1E82\u0174\u1E86\u1E84\u1E88\u2C72]/g},
			{'base':'X', 'letters':/[\u0058\u24CD\uFF38\u1E8A\u1E8C]/g},
			{'base':'Y', 'letters':/[\u0059\u24CE\uFF39\u1EF2\u00DD\u0176\u1EF8\u0232\u1E8E\u0178\u1EF6\u1EF4\u01B3\u024E\u1EFE]/g},
			{'base':'Z', 'letters':/[\u005A\u24CF\uFF3A\u0179\u1E90\u017B\u017D\u1E92\u1E94\u01B5\u0224\u2C7F\u2C6B\uA762]/g},
			{'base':'a', 'letters':/[\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250]/g},
			{'base':'aa','letters':/[\uA733]/g},
			{'base':'ae','letters':/[\u00E6\u01FD\u01E3]/g},
			{'base':'ao','letters':/[\uA735]/g},
			{'base':'au','letters':/[\uA737]/g},
			{'base':'av','letters':/[\uA739\uA73B]/g},
			{'base':'ay','letters':/[\uA73D]/g},
			{'base':'b', 'letters':/[\u0062\u24D1\uFF42\u1E03\u1E05\u1E07\u0180\u0183\u0253]/g},
			{'base':'c', 'letters':/[\u0063\u24D2\uFF43\u0107\u0109\u010B\u010D\u00E7\u1E09\u0188\u023C\uA73F\u2184]/g},
			{'base':'d', 'letters':/[\u0064\u24D3\uFF44\u1E0B\u010F\u1E0D\u1E11\u1E13\u1E0F\u0111\u018C\u0256\u0257\uA77A]/g},
			{'base':'dz','letters':/[\u01F3\u01C6]/g},
			{'base':'e', 'letters':/[\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD]/g},
			{'base':'f', 'letters':/[\u0066\u24D5\uFF46\u1E1F\u0192\uA77C]/g},
			{'base':'g', 'letters':/[\u0067\u24D6\uFF47\u01F5\u011D\u1E21\u011F\u0121\u01E7\u0123\u01E5\u0260\uA7A1\u1D79\uA77F]/g},
			{'base':'h', 'letters':/[\u0068\u24D7\uFF48\u0125\u1E23\u1E27\u021F\u1E25\u1E29\u1E2B\u1E96\u0127\u2C68\u2C76\u0265]/g},
			{'base':'hv','letters':/[\u0195]/g},
			{'base':'i', 'letters':/[\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131]/g},
			{'base':'j', 'letters':/[\u006A\u24D9\uFF4A\u0135\u01F0\u0249]/g},
			{'base':'k', 'letters':/[\u006B\u24DA\uFF4B\u1E31\u01E9\u1E33\u0137\u1E35\u0199\u2C6A\uA741\uA743\uA745\uA7A3]/g},
			{'base':'l', 'letters':/[\u006C\u24DB\uFF4C\u0140\u013A\u013E\u1E37\u1E39\u013C\u1E3D\u1E3B\u017F\u0142\u019A\u026B\u2C61\uA749\uA781\uA747]/g},
			{'base':'lj','letters':/[\u01C9]/g},
			{'base':'m', 'letters':/[\u006D\u24DC\uFF4D\u1E3F\u1E41\u1E43\u0271\u026F]/g},
			{'base':'n', 'letters':/[\u006E\u24DD\uFF4E\u01F9\u0144\u00F1\u1E45\u0148\u1E47\u0146\u1E4B\u1E49\u019E\u0272\u0149\uA791\uA7A5]/g},
			{'base':'nj','letters':/[\u01CC]/g},
			{'base':'o', 'letters':/[\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275]/g},
			{'base':'oi','letters':/[\u01A3]/g},
			{'base':'ou','letters':/[\u0223]/g},
			{'base':'oo','letters':/[\uA74F]/g},
			{'base':'p','letters':/[\u0070\u24DF\uFF50\u1E55\u1E57\u01A5\u1D7D\uA751\uA753\uA755]/g},
			{'base':'q','letters':/[\u0071\u24E0\uFF51\u024B\uA757\uA759]/g},
			{'base':'r','letters':/[\u0072\u24E1\uFF52\u0155\u1E59\u0159\u0211\u0213\u1E5B\u1E5D\u0157\u1E5F\u024D\u027D\uA75B\uA7A7\uA783]/g},
			{'base':'s','letters':/[\u0073\u24E2\uFF53\u00DF\u015B\u1E65\u015D\u1E61\u0161\u1E67\u1E63\u1E69\u0219\u015F\u023F\uA7A9\uA785\u1E9B]/g},
			{'base':'t','letters':/[\u0074\u24E3\uFF54\u1E6B\u1E97\u0165\u1E6D\u021B\u0163\u1E71\u1E6F\u0167\u01AD\u0288\u2C66\uA787]/g},
			{'base':'tz','letters':/[\uA729]/g},
			{'base':'u','letters':/[\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289]/g},
			{'base':'v','letters':/[\u0076\u24E5\uFF56\u1E7D\u1E7F\u028B\uA75F\u028C]/g},
			{'base':'vy','letters':/[\uA761]/g},
			{'base':'w','letters':/[\u0077\u24E6\uFF57\u1E81\u1E83\u0175\u1E87\u1E85\u1E98\u1E89\u2C73]/g},
			{'base':'x','letters':/[\u0078\u24E7\uFF58\u1E8B\u1E8D]/g},
			{'base':'y','letters':/[\u0079\u24E8\uFF59\u1EF3\u00FD\u0177\u1EF9\u0233\u1E8F\u00FF\u1EF7\u1E99\u1EF5\u01B4\u024F\u1EFF]/g},
			{'base':'z','letters':/[\u007A\u24E9\uFF5A\u017A\u1E91\u017C\u017E\u1E93\u1E95\u01B6\u0225\u0240\u2C6C\uA763]/g}
		];

		for(var i=0; i<defaultDiacriticsRemovalMap.length; i++) {
			str = str.replace(defaultDiacriticsRemovalMap[i].letters, defaultDiacriticsRemovalMap[i].base);
		}

		return str;

	}
	
	// Object containing specific "Save Changes" method
	save_changes = {};
	
	// Object comaining specific "Load Values" method. 
	load_values = {};
	
	
	/* Common method for all controls with Label and Name */
	load_values.common = function(ctrl_type, ctrl_id) {
		var form = $("#theForm");
		var div_ctrl = $("#"+ctrl_id);
		
		form.find("[name=label]").val(div_ctrl.find('.control-label').text())
		var specific_load_method = load_values[ctrl_type];
		if(typeof(specific_load_method)!='undefined') {
			specific_load_method(ctrl_type, ctrl_id);		
		}
	}
	
	/* Specific method to load values from a textbox control to the customization dialog */
	load_values.textbox = function(ctrl_type, ctrl_id) {
		var form = $("#theForm");
		var div_ctrl = $("#"+ctrl_id);
		var ctrl = div_ctrl.find("input")[0];
		form.find("[name=name]").val(ctrl.name)		
		form.find("[name=placeholder]").val(ctrl.placeholder)		
	}
	
	// Passwordbox uses the same functionality as textbox - so just point to that
	load_values.passwordbox = load_values.textbox;
	
	
	// Text uses the same functionality as textbox - so just point to that
	load_values.textarea = function(ctrl_type, ctrl_id) {
		var form = $("#theForm");
		var div_ctrl = $("#"+ctrl_id);
		var ctrl = div_ctrl.find("textarea")[0];
		form.find("[name=name]").val(ctrl.name)	
		form.find("[name=placeholder]").val(ctrl.placeholder)		
	}

	
	/* Specific method to load values from a combobox control to the customization dialog  */
	load_values.combobox = function(ctrl_type, ctrl_id) {
		var form = $("#theForm");
		var div_ctrl = $("#"+ctrl_id);
		var ctrl = div_ctrl.find("select")[0];
		form.find("[name=name]").val(ctrl.name)
		var options= '';
		$(ctrl).find('option').each(function(i,o) { options+=o.text+'\n'; });
		form.find("[name=options]").val($.trim(options));
	}
	// Multi-select combobox has same customization features
	load_values.selectmultiplelist = load_values.combobox;
	
	
	/* Specific method to load values from a radio group */
	load_values.radiogroup = function(ctrl_type, ctrl_id) {
		var form = $("#theForm");
		var div_ctrl = $("#"+ctrl_id);
		var options= '';
		var ctrls = div_ctrl.find("div").find("label");
		var radios = div_ctrl.find("div").find("input");
		
		ctrls.each(function(i,o) { options+=$(o).text()+'\n'; });
		form.find("[name=name]").val(radios[0].name)
		form.find("[name=options]").val($.trim(options));
	}
	
	// Checkbox group  customization behaves same as radio group
	load_values.checkboxgroup = load_values.radiogroup;
	
	/* Specific method to load values from a button */
	load_values.btn = function(ctrl_type, ctrl_id) {
		var form = $("#theForm");
		var div_ctrl = $("#"+ctrl_id);
		var ctrl = div_ctrl.find("button")[0];
		form.find("[name=name]").val(ctrl.name)		
		form.find("[name=label]").val($(ctrl).text().trim())		
	}
	
	/* Common method to save changes to a control  - This also calls the specific methods */
	
	save_changes.common = function(values) {
		var div_ctrl = $("#"+values.forCtrl);
		div_ctrl.find('.control-label').text(values.label);
		var specific_save_method = save_changes[values.type];
		if(typeof(specific_save_method)!='undefined') {
			specific_save_method(values);		
		}
	}
	
	/* Specific method to save changes to a text box */
	save_changes.textbox = function(values) {
		var div_ctrl = $("#"+values.forCtrl);
		var ctrl = div_ctrl.find("input")[0];
		ctrl.placeholder = values.placeholder;
		//ctrl.name = values.label.replace(/[^a-z0-9\s]/gi, '');
		ctrl.name = removeDiacritics(values.label).replace(/ /g, '_');
		//console.log(values);
	}

	// Password box customization behaves same as textbox
	save_changes.passwordbox= save_changes.textbox;

	// Text box customization behaves same as textbox
	save_changes.textarea= function(values) {
		var div_ctrl = $("#"+values.forCtrl);
		var ctrl = div_ctrl.find("textarea")[0];
		ctrl.placeholder = values.placeholder;
		ctrl.name = removeDiacritics(values.label).replace(/ /g, '_');
		//console.log(values);
	}

	// Text box customization behaves same as textbox
	save_changes.file= function(values) {
		var div_ctrl = $("#"+values.forCtrl);
		var ctrl = div_ctrl.find("input")[0];
		ctrl.name = removeDiacritics(values.label).replace(/ /g, '_');
		//console.log(values);
	}

	/* Specific method to save changes to a combobox */
	save_changes.combobox = function(values) {
		console.log(values);
		var div_ctrl = $("#"+values.forCtrl);
		var ctrl = div_ctrl.find("select")[0];
		ctrl.name = removeDiacritics(values.label).replace(/ /g, '_')+'[]';
		$(ctrl).empty();
		$(values.options.split('\n')).each(function(i,o) {
			$(ctrl).append("<option>"+$.trim(o)+"</option>");
		});
	}
	
	/* Specific method to save a radiogroup */
	save_changes.radiogroup = function(values) {
		var div_ctrl = $("#"+values.forCtrl);
		
		var label_template = $(".selectorField .ctrl-radiogroup label")[0];
		var radio_template = $(".selectorField .ctrl-radiogroup input")[0];
		
		var ctrl = div_ctrl.find(".ctrl-radiogroup");
		ctrl.empty();
		$(values.options.split('\n')).each(function(i,o) {
			var label = $(label_template).clone().text($.trim(o))
			var radio = $(radio_template).clone();
			radio[0].name = ctrl.name = removeDiacritics(values.label).replace(/ /g, '_')+'['+i+']';
			radio[0].value = $.trim(o);
			label.append(radio);
			$(ctrl).append(label);
		});
	}
	
	/* Same as radio group, but separated for simplicity */
	save_changes.checkboxgroup = function(values) {
		var div_ctrl = $("#"+values.forCtrl);
		
		var label_template = $(".selectorField .ctrl-checkboxgroup label")[0];
		var checkbox_template = $(".selectorField .ctrl-checkboxgroup input")[0];
		
		var ctrl = div_ctrl.find(".ctrl-checkboxgroup");
		ctrl.empty();
		$(values.options.split('\n')).each(function(i,o) {
			var label = $(label_template).clone().text($.trim(o))
			var checkbox = $(checkbox_template).clone();
			checkbox[0].name = ctrl.name = removeDiacritics(values.label).replace(/ /g, '_')+'[]';
			checkbox[0].value = $.trim(o);
			label.append(checkbox);
			$(ctrl).append(label);
		});
	}
	
	// Multi-select customization behaves same as combobox
	save_changes.selectmultiplelist = save_changes.combobox;
	
	/* Specific method for Button */
	save_changes.btn = function(values) {
		var div_ctrl = $("#"+values.forCtrl);
		var ctrl = div_ctrl.find("button")[0];
		$(ctrl).html($(ctrl).html().replace($(ctrl).text()," "+$.trim(values.label)));
		ctrl.name = removeDiacritics(values.label).replace(/ /g, '_');
		//console.log(values);
	}

	
	/* Save the changes due to customization 
		- This method collects the values and passes it to the save_changes.methods
	*/
	function save_customize_changes(e, obj) {
		//console.log('save clicked', arguments);
		var formValues = {};
		var val=null;
		$("#theForm").find("input, textarea, select").each(function(i,o) {
			if(o.type=="checkbox"){
				val = o.checked;
			} else {
				val = o.value;
			}
			formValues[o.name] = val;
		});
		save_changes.common(formValues);
	}
	
	/*
		Opens the customization window for this
	*/
	function customize_ctrl(ctrl_type, ctrl_id) {
		console.log(ctrl_type);
		var ctrl_params = {};

		/* Load the specific templates */
		var specific_template = templates[ctrl_type];
		if(typeof(specific_template)=='undefined') {
			specific_template = function(){return ''; };
		}
		var modal_header = $("#"+ctrl_id).find('.control-label').text();
		
		var template_params = {
			header:modal_header, 
			content: specific_template(ctrl_params), 
			type: ctrl_type,
			forCtrl: ctrl_id
		}
		
		// Pass the parameters - along with the specific template content to the Base template
		var s = templates.common(template_params)+"";
		
		
		$("[name=customization_modal]").remove(); // Making sure that we just have one instance of the modal opened and not leaking
		$('<div id="customization_modal" name="customization_modal" class="modal hide fade" />').append(s).modal('show');
		
		setTimeout(function() {
			// For some error in the code  modal show event is not firing - applying a manual delay before load
			load_values.common(ctrl_type, ctrl_id);
		},300);
	}

</script>
<!--[if lt IE 9]>
	<b class="text-error">All components may not work correctly on IE 8 or below </b><br/><br/>
	<![endif]-->
  <legend>Creador de formularios</legend>
    <?php 
		$nConexion    = Conectar();
		mysqli_set_charset($nConexion,'utf8');
		$Resultado    = mysqli_query($nConexion, "SELECT * FROM campos" );
	?>
  <div class="tabbable">
	<div class="row-fluid">
    <div id="listOfFields" class="span3 well tab-content">
	  <div class="tab-pane active" id="simple">
            <?php while($r = mysqli_fetch_assoc($Resultado)): ?>
            <div class='selectorField draggableField'>
                <label class="control-label"><?=$r["campo"];?></label>
				<?php if($r["tipo"]=="textarea"){ ?>     
                <textarea class="ctrl-textarea" placeholder="<?=$r["campo"];?>" name="<?=$r["campo"];?>"></textarea>
				<?php } else { ?>     
                <input type="<?=$r["tipo"];?>" placeholder="<?=$r["campo"];?>" class="ctrl-textbox" name="<?=$r["campo"];?>"></input>
            	<?php  } ?>
            </div>
           <?php endwhile; ?>
	  </div>
    </div>
	
	<!-- 
		Below we have the columns to drop controls
			-- Removed the TABLE based implementations from earlier code
			-- Grid system used for rendering columns 
			-- Columns can be simply added by defining a div with droppedFields class
	-->
	<div class="span8" id="selected-content">
		<!--[if lt IE 9]>
		<div class="row-fluid" id="form-title-div">
			<label>Type form title here...</label>
		</div>
		<![endif]-->
        <?php 
		$Registro["titulo"] ="";
		$categorias = mysqli_query($nConexion, "select id,titulo from tblmatriz" );
		if($nId!=0){
		$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = '$nId'" );
		$Registro     = mysqli_fetch_array( $Resultado );

		} ?>
      <form id="target" class="form-horizontal" method="post" action="categorias.php?Accion=Guardar">
      <input type="hidden" id="txtId" name="txtId" value="<?=$nId?>"/>
	  <div class="row-fluid" id="form-title-div">
		<input type="text" class="input-large span10" placeholder="Titulo del formulario" id="form-title" name="tituloMatriz" value="<?=$Registro["titulo"]?>" required="required"></input><br>
        Tipo: <select name="tipo" id="tipo">
        	<option value="1" <?=$Registro["tipo"]==1?"selected":"";?>>Contenido</option>
        	<option value="2" <?=$Registro["tipo"]==2?"selected":"";?>>Formulario</option>
        </select>
        Categoría: <select name="categoria" id="categoria">
        	<option value="0">Principal</option>
        	<?php 
             while($r = mysqli_fetch_assoc($categorias)): ?>
        	<option value="<?php echo $r["id"];?>" <?=$r["id"]==$Registro["idcategoria"]?"selected":"";?>><?php echo $r["titulo"];?></option>
            </div>
           <?php endwhile; ?>
        </select>
	  </div>
	  <div class="row-fluid" id="guardarForm">
		<div id="selected-column-1" class="span10 well droppedFields ui-droppable ui-sortable" style="z-index: 10;">
        </div>
	  </div>
      <input type="submit" alt="Guardar Registro." value="Guardar" id="save"/>
      <a href="categorias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
      </form>
	  <!-- Action bar - Suited for buttons on form 
	  <div class="row-fluid">
		<div id="selected-action-column" class="span10 well action-bar droppedFields" style="min-height:80px;"></div>
	  </div>-->
	</div>
	</div>

	<!-- Preview button 
	<div class="row-fluid">	
		<div class="span12">
			<input type="button" class="btn btn-primary" value="Preview" onclick="preview();"></input>
		</div>
	</div>-->
  </div>

<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>


<script type="text/javascript" src="jqueryui/ui/minified/jquery-ui.min.js"></script>

<!-- using handlebars for templating, but DustJS might be better for the current purpose -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/1.0.0-rc.3/handlebars.min.js"></script>

<!-- 
	Starting templates declaration
	DEV-NOTE: Keeping the templates and code simple here for demo  -- use some better template inheritance for multiple controls 
---> 

<script id="control-customize-form" type="text/x-handlebars-template">
	<div class="modal-header">
		<h3>{{header}}</h3>
	</div>
	<div class="modal-body">
		<form id="theForm" class="form-horizontal">
			<input type="hidden" value="{{type}}" name="type"></input>
			<input type="hidden" value="{{forCtrl}}" name="forCtrl"></input>
			<p><label class="control-label">Label</label> <input type="text" name="label" value=""></input></p>
			{{{content}}}
			<p><label class="control-label">Campo requerido</label> <input type="checkbox" name="required" value=""></input></p>
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" data-dismiss="modal" onclick='save_customize_changes()'>Save changes</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick='delete_ctrl()'>Delete</button>
	</div>
</script>

<script id="control-customize-content" type="text/x-handlebars-template">
	<div class="modal-header">
		<h3>{{header}}</h3>
	</div>
	<div class="modal-body">
		<form id="theForm" class="form-horizontal">
			<input type="hidden" value="{{type}}" name="type"></input>
			<input type="hidden" value="{{forCtrl}}" name="forCtrl"></input>
			{{{content}}}
			<p><label class="control-label">Campo requerido</label> <input type="checkbox" name="required" value=""></input></p>
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" data-dismiss="modal" onclick='save_customize_changes()'>Save changes</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick='delete_ctrl()'>Delete</button>
	</div>
</script>

<script id="textbox-template" type="text/x-handlebars-template">
	<p><label class="control-label">Placeholder</label> <input type="text" name="placeholder" value=""></input></p>
</script>

<script id="combobox-template" type="text/x-handlebars-template">
	<p><label class="control-label">Options</label> <textarea name="options" rows="5"></textarea></p>
</script>

<!-- End of templates -->
<script>
	$(document).ready(docReady);
</script>
<hr/>
<h6>
Uso:
  <ul>
	  <li>Arrastrar los campos desde la izquierda</li>
	  <li>hacer click en los campos para personalizar</li>
  </ul>
</h6>			
<?php
  }
  ###############################################################################

  function CategoriasGuardar( $d , $files) {
	include("../../vargenerales.php");
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
	$nId = $d["txtId"];
	setlocale(LC_ALL, 'en_US.UTF8');
	$titulo = $d["tituloMatriz"];
	$tabla = slug($titulo);
	$tipo = $d["tipo"];
	$type = $d["type"];
	unset($d["type"]);
	
	$categoria = $d["categoria"];
	$form = "";
    if ( $nId <= 0 ) {
	  	mysqli_query($nConexion,"INSERT INTO tblmatriz ( idcategoria,titulo,tabla,tipo,idciudad ) VALUES ('$categoria','$titulo','$tabla','$tipo',$IdCiudad )");
      	$idMatriz = mysqli_insert_id($nConexion);
		if($tipo==1){
			array_splice($d, 0, 4 );
			$sql = "CREATE TABLE `$tabla` (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, idcategoria INT NOT NULL DEFAULT '0'";
			foreach ($d as $field => $value ) {
			mysqli_query($nConexion,"INSERT INTO campos_matriz ( campo,idmatriz ) VALUES ('$field','$idMatriz')");
			$sql.=", `$field` TEXT NOT NULL";
			}
			foreach ($files as $field => $value ) { 
			mysqli_query($nConexion,"INSERT INTO campos_matriz ( campo,idmatriz ) VALUES ('$field','$idMatriz')");
			$sql.=", `$field` TEXT NOT NULL";
			}
			$sql.=", metaTitulo varchar(250) NOT NULL, metaDescripcion TEXT NOT NULL, tags TEXT NOT NULL, palabras TEXT NOT NULL, publicar CHAR NOT NULL, idioma CHAR(2) NOT NULL, url varchar(250) NOT NULL, fechapub DATE NOT NULL";
			$sql.=")"; 
			$ra = mysqli_query($nConexion,$sql);
		} elseif($tipo==2){
			array_splice($d, 0, 3 );
			mysqli_query($nConexion,"INSERT INTO configuracion_form ( idform ) VALUES ('$idMatriz')");
			$sql = "CREATE TABLE `$tabla` (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, idcategoria INT NOT NULL DEFAULT '0'";
			$i=0;
			foreach ($d as $field => $value ) {
				mysqli_query($nConexion,"INSERT INTO campos_form ( campo,tipo,idform ) VALUES ('$field','$type[$i]','$idMatriz')");
				$sql.=", `$field` TEXT NOT NULL";
				$i++;
				if(is_array($value)){
					$idCampo = mysqli_insert_id($nConexion);
					foreach ($field as $opcion ) {
						mysqli_query($nConexion,"INSERT INTO campos_opciones ( opcion,idcampo ) VALUES ('$opcion','$idCampo')");
					}
				}
			}
			foreach ($files as $field => $value ) { 
			mysqli_query($nConexion,"INSERT INTO campos_form ( campo,tipo,idform ) VALUES ('$field','file','$idMatriz')");
			$sql.=", `$field` TEXT NOT NULL";
			}
			$sql.=", publicar CHAR NOT NULL, idioma CHAR(2) NOT NULL, url varchar(250) NOT NULL, fechapub DATE NOT NULL";
			$sql.=")"; 
			$ra = mysqli_query($nConexion,$sql);
		}
      if ( !$ra ) {
	Mensaje("Error registrando nueva categoria. Error:". mysqli_error($nConexion), "categorias_listar.php" );
	exit;
      }
      mysqli_close($nConexion);
	  if (!is_dir($cRutaImgGeneral . $tabla)) {
    mkdir($cRutaImgGeneral . $tabla, 0777, true);
}
      Mensaje( "El registro ha sido almacenado correctamente.", "categorias_listar.php" ) ;
      return;
    }
    else {
		$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = '$nId'" ) ;
		$Registro     = mysqli_fetch_array( $Resultado );
		$tablaOld = $Registro["tabla"];
		$sql = "RENAME TABLE `$tablaOld` TO `$tabla`";
		mysqli_query($nConexion,$sql);
		
    	$cTxtSQLUpdate = "UPDATE tblmatriz SET titulo='{$titulo}',tabla='{$tabla}',idcategoria='{$categoria}',tipo='{$tipo}',idciudad='{$IdCiudad}' WHERE id = {$nId} ";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
		
		$sql = "ALTER TABLE `$tabla`";
		if($tipo==1){
		$campos    = mysqli_query($nConexion, "SELECT ca.* FROM campos ca JOIN campos_matriz cm on (ca.campo=cm.campo) WHERE cm.idmatriz = '$nId' ORDER BY cm.id ASC" );
		array_splice($d, 0, 4 );
    	mysqli_query($nConexion, "DELETE FROM campos_matriz WHERE idmatriz = $nId " );
		while($row=mysqli_fetch_assoc($campos)) {
			$camposA[] = $row["campo"];
			if(!array_key_exists($row["campo"], $d) && !array_key_exists($row["campo"], $files)):
				$sql.=" DROP COLUMN {$row["campo"]},";
			endif;
		}
		foreach ($d as $field => $value ) {
			mysqli_query($nConexion,"INSERT INTO campos_matriz ( campo,idmatriz ) VALUES ('$field','$nId')");
			if(!in_array($field, $camposA)):
				$sql.=" ADD COLUMN `$field` TEXT NOT NULL,";
			endif;
		}
		foreach ($files as $field => $value ) {
	  		mysqli_query($nConexion,"INSERT INTO campos_matriz ( campo,idmatriz ) VALUES ('$field','$nId')");
			if(!in_array($field, $camposA)):
				$sql.=" ADD COLUMN `$field` VARCHAR(255) NOT NULL,";
			endif;
		}
		$sql.=" MODIFY COLUMN idioma CHAR(2);";
      $ra = mysqli_query($nConexion,$sql);
		} elseif($tipo==2){
		$campos    = mysqli_query($nConexion, "SELECT * FROM campos_form WHERE idform = '$nId' ORDER BY idcampo ASC" );
		array_splice($d, 0, 3 );
    	mysqli_query($nConexion, "DELETE FROM campos_form WHERE idform = $nId " );
		while($row=mysqli_fetch_assoc($campos)) {
			$camposA[] = $row["campo"];
			if(!array_key_exists($row["campo"], $d) && !array_key_exists($row["campo"], $files)):
				$sql.=" DROP COLUMN {$row["campo"]},";
			endif;
		}
		$i=0;
		foreach ($d as $field => $value ) {
			mysqli_query($nConexion,"INSERT INTO campos_form ( campo,tipo,idform ) VALUES ('$field','$type[$i]','$nId')");
			if(!in_array($field, $camposA)):
				$sql.=" ADD COLUMN `$field` TEXT NOT NULL,";
			endif;
			$i++;
			if(is_array($value)){
				$idCampo = mysqli_insert_id($nConexion);
				foreach ($value as $opcion ) {
					mysqli_query($nConexion,"INSERT INTO campos_opciones ( opcion,idcampo ) VALUES ('$opcion','$idCampo')");
				}
			}
		}
		foreach ($files as $field => $value ) {
			mysqli_query($nConexion,"INSERT INTO campos_form ( campo,tipo,idform ) VALUES ('$field','file','$nId')");
			if(!in_array($field, $camposA)):
				$sql.=" ADD COLUMN `$field` VARCHAR(255) NOT NULL,";
			endif;
		}
		$sql.=" MODIFY COLUMN idioma CHAR(2);";
      $ra = mysqli_query($nConexion,$sql);
		}
	if ( !$ra ) {
	  Mensaje("Error actualizando tabla {$nId}:". mysqli_error($nConexion),"categorias_listar.php");
	  exit;
	}
		
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "categorias_listar.php" ) ;
    	return;
    }
  }
  function CategoriasEliminar( $nId )
  {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $sql = "DELETE FROM tblmatriz WHERE id = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando categoria {$nId}","categorias_listar.php");
      exit;
    }
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","categorias_listar.php" );
    exit();
  }
?>