var timer;
var is_function_loaded=true;
function ClearFromLocalStorage(){
    
    localStorage.removeItem('myinvoice');
    $('#local_invoice_div').hide();
    
}

function autoRound(num)
{
	num5=num.toFixed(6);
	num11=num.toFixed(11);
	frac=Math.abs(num11-num5);
	
	if(frac*100000000<10)
	{
		num=num.toFixed(6)/1;
	}
	return num;
}

function round( num, precision ) {
    return ((+(Math.round(+(num + 'e' + precision)) + 'e' + -precision)).toFixed(precision))/1;
}

function in_format(x)
{
	x=x.toString();
	var afterPoint = '';
	if(x.indexOf('.') > 0)
	   afterPoint = x.substring(x.indexOf('.'),x.length);
	x = Math.floor(x);
	x=x.toString();
	var lastThree = x.substring(x.length-3);
	var otherNumbers = x.substring(0,x.length-3);
	if(otherNumbers != '')
		lastThree = ',' + lastThree;
	var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
	return res;
}


function escapeRegExp(str) {
    return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

function empty(value){ 
	if (typeof value === 'undefined' || value === null || value === '' || value === ' ')  return true;
	return false;
}

function replaceAll(str, find, replace) {
  return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

var _formatPriceCurrencies = [];
var number_formats = [];
function format_price(price,code,ajax_function){

		currencies = _formatPriceCurrencies;
        if(currencies != {} && currencies != null && currencies.length != 0)
        {
            price = parseFloat(price);
            $org_price=price;
            if ( typeof(price) == "undefined" || price === null || price === '0.00' || price == 'NaN') price=0;

            if(code){
                    format=currencies[code];
                    if (code!='INR'&& (typeof(number_formats) == "undefined" || number_formats === null || typeof(number_formats[code]) == "undefined" || number_formats[code] === null))
                    {
                            number_formats[code]=[2,".",","];
                            currencies[code]=replaceAll(currencies[code],'%0.2f','%s');
                    }
                    if ( typeof(number_formats) != "undefined" && number_formats !== null && typeof(number_formats[code]) != "undefined" && number_formats[code] !== null) {
                            if( typeof(number_formats[code+'-'+country_code]) != "undefined" && number_formats[code+'-'+country_code] !== null )
                            {
                                    code= code+'-'+country_code;
                                    format=currencies[code];
                            }

                            if(number_formats[code][0]==0&&Math.abs(Math.floor($org_price*10)-$org_price*10)>=0.05) number_formats[code][0]=2;
                            if(number_formats[code][0]==0&&Math.abs(Math.floor($org_price)-$org_price)>=0.005) number_formats[code][0]=1;

                            format=currencies[code];
                price = price.toFixed(number_formats[code][0]);
                            price = numberWithSeprator(price);
                            price = sprintf(format, price);
                            price=price.replace(/(\d)\./g, '$1***');
                            price=price.replace(/(\d),/g, '$1'+number_formats[code][2]);
                            price=price.replace(/\*\*\*/g, number_formats[code][1]);
                            price = replaceAll(price,' ','\xa0');

                            
                            ajax_function(price)
                            return ;
            }
                    if(code=='INR')
                    {
                            price=in_format(price);
                    }
                    ajax_function(sprintf(format, price).replace(' ','\xa0'));
                    return ;
            }
            ajax_function(price.toFixed(2));
                return ;
    }else{
        $.ajax({
            'url': '/sites/get_format_price_variables',
            dataType: 'json',
            success: function(data){
                number_formats = data.number_formats;
                currencies = data.currencies;
                _formatPriceCurrencies = currencies;
                country_code = data.country_code;
                price = parseFloat(price);
                $org_price=price;

                if ( typeof(price) == "undefined" || price === null || price === '0.00' || price == 'NaN') price=0;

                if(code){
                        format=currencies[code];
                        if (code!='INR'&& (typeof(number_formats) == "undefined" || number_formats === null || typeof(number_formats[code]) == "undefined" || number_formats[code] === null))
                        {
                                number_formats[code]=[2,".",","];
                                currencies[code]=replaceAll(currencies[code],'%0.2f','%s');
                        }
                        if ( typeof(number_formats) != "undefined" && number_formats !== null && typeof(number_formats[code]) != "undefined" && number_formats[code] !== null) {
                                if( typeof(number_formats[code+'-'+country_code]) != "undefined" && number_formats[code+'-'+country_code] !== null )
                                {
                                        code= code+'-'+country_code;
                                        format=currencies[code];
                                }

                                if(number_formats[code][0]==0&&Math.abs(Math.floor($org_price*10)-$org_price*10)>=0.05) number_formats[code][0]=2;
                                if(number_formats[code][0]==0&&Math.abs(Math.floor($org_price)-$org_price)>=0.005) number_formats[code][0]=1;

                                format=currencies[code];
                    price = price.toFixed(number_formats[code][0]);
                                price = numberWithSeprator(price);
                                price = sprintf(format, price);
                                price=price.replace(/(\d)\./g, '$1***');
                                price=price.replace(/(\d),/g, '$1'+number_formats[code][2]);
                                price=price.replace(/\*\*\*/g, number_formats[code][1]);
                                price = replaceAll(price,' ','\xa0');

                                ajax_function(price)
                                return ;
//                                return price;
                }
                        if(code=='INR')
                        {
                                price=in_format(price);
                        }
                        ajax_function(sprintf(format, price).replace(' ','\xa0'));
                        return ;
//                        return sprintf(format, price).replace(' ','\xa0');
                }
                ajax_function(price.toFixed(2));
                return ;
//                return price.toFixed(2);
            }
        })
    }
}

function numberWithSeprator(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function render(fn){
	timer = setInterval(function() {
		if (typeof fn === 'undefined') {
			fn = null;
		}
		renderIt(fn);
	}, 40);
}

function sprintf () {
	var regex = /%%|%(\d+\$)?([-+\'#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuidfegEG])/g;
	var a = arguments,
	i = 0,
	format = a[i++];

	//pad()
	var pad = function (str, len, chr, leftJustify) {
		if (!chr) {
			chr = ' ';
		}
		var padding = (str.length >= len) ? '' : Array(1 + len - str.length >>> 0).join(chr);
		return leftJustify ? str + padding : padding + str;
	};

	// justify()
	var justify = function (value, prefix, leftJustify, minWidth, zeroPad, customPadChar) {
		var diff = minWidth - value.length;
		if (diff > 0) {
			if (leftJustify || !zeroPad) {
				value = pad(value, minWidth, customPadChar, leftJustify);
			} else {
				value = value.slice(0, prefix.length) + pad('', diff, '0', true) + value.slice(prefix.length);
			}
		}
		return value;
	};
	// formatBaseX()
	var formatBaseX = function (value, base, prefix, leftJustify, minWidth, precision, zeroPad) {
		// Note: casts negative numbers to positive ones
		var number = value >>> 0;
		prefix = prefix && number && {
			'2': '0b',
			'8': '0',
			'16': '0x'
		}
		[base] || '';
		value = prefix + pad(number.toString(base), precision || 0, '0', false);
		return justify(value, prefix, leftJustify, minWidth, zeroPad);
	};

	// formatString()
	var formatString = function (value, leftJustify, minWidth, precision, zeroPad, customPadChar) {
		if (precision != null) {
			value = value.slice(0, precision);
		}
		return justify(value, '', leftJustify, minWidth, zeroPad, customPadChar);
	};

	// doFormat()
	var doFormat = function (substring, valueIndex, flags, minWidth, _, precision, type) {
		var number;
		var prefix;
		var method;
		var textTransform;
		var value;
		if (substring == '%%') {
			return '%';
		}

		// parse flags
		var leftJustify = false,
		positivePrefix = '',
		zeroPad = false,
		prefixBaseX = false,
		customPadChar = ' ';
		var flagsl = flags.length;
		for (var j = 0; flags && j < flagsl; j++) {
			switch (flags.charAt(j)) {
				case ' ':
					positivePrefix = ' ';
					break;
				case '+':
					positivePrefix = '+';
					break;
				case '-':
					leftJustify = true;
					break;
				case "'":
					customPadChar = flags.charAt(j + 1);
					break;
				case '0':
					zeroPad = true;
					break;
				case '#':
					prefixBaseX = true;
					break;
			}
		}

		// parameters may be null, undefined, empty-string or real valued        // we want to ignore null, undefined and empty-string values
		if (!minWidth) {
			minWidth = 0;
		} else if (minWidth == '*') {
			minWidth = +a[i++];
		} else if (minWidth.charAt(0) == '*') {
			minWidth = +a[minWidth.slice(1, -1)];
		} else {
			minWidth = +minWidth;
		}
		// Note: undocumented perl feature:
		if (minWidth < 0) {
			minWidth = -minWidth;
			leftJustify = true;
		}

		if (!isFinite(minWidth)) {
			throw new Error('sprintf: (minimum-)width must be finite');
		}
		if (!precision) {
			precision = 'fFeE'.indexOf(type) > -1 ? 6 : (type == 'd') ? 0 : undefined;
		} else if (precision == '*') {
			precision = +a[i++];
		} else if (precision.charAt(0) == '*') {
			precision = +a[precision.slice(1, -1)];
		} else {
			precision = +precision;
		}
		// grab value using valueIndex if required?
		value = valueIndex ? a[valueIndex.slice(0, -1)] : a[i++];

		switch (type) {
			case 's':
				return formatString(String(value), leftJustify, minWidth, precision, zeroPad, customPadChar);
			case 'c':
				return formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, zeroPad);
			case 'b':
				return formatBaseX(value, 2, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'o':
				return formatBaseX(value, 8, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'x':
				return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'X':
				return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad).toUpperCase();
			case 'u':
				return formatBaseX(value, 10, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'i':        case 'd':
				number = (+value) | 0;
				prefix = number < 0 ? '-' : positivePrefix;
				value = prefix + pad(String(Math.abs(number)), precision, '0', false);
				return justify(value, prefix, leftJustify, minWidth, zeroPad);
			case 'e':
			case 'E':
			case 'f':
			case 'F':
			case 'g':        case 'G':
				number = +value;
				prefix = number < 0 ? '-' : positivePrefix;
				method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(type.toLowerCase())];
				textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(type) % 2];
				value = prefix + Math.abs(number)[method](precision);
				return justify(value, prefix, leftJustify, minWidth, zeroPad)[textTransform]();
			default:
				return substring;
		}
	};

return format.replace(regex, doFormat);
}

function renderIt(fn){
	if (1) {
		clearInterval(timer);
		if (typeof fn === 'function') {
			fn();
		}
		return;
	}
}

function __(text) {
	if(typeof translate_languages == 'undefined' || translate_languages[text]==undefined || translate_languages[text]==''){
          
		return text;
	}else{
             
		return translate_languages[text];
	}
	return false;
}

function toTitleCase(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

function isVisible(selector){
	return $(selector).is(':visible');
}

function string2number(value){
	return isNaN(parseFloat(value))? 0 : value * 1;
}

function isNumeric(value){
	return !notEmpty(value) || !isNaN(parseFloat(value));
}

function notEmpty(value){
    if(value!=undefined){
	return value.toString() != '';
    }else{
        return false;
    }
}

function isNotMinus(value){
	return string2number(value) >= 0;
}
function Email(value){
	return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(value);
}
function lessThan(compareValue){
	return this < compareValue;
}

function lessThanOrEqual(compareValue){
	return this <= compareValue;
}

function betweenPercentage(value){
	return (value >= 0 && value <= 100);
}

function maxLength(length){
	return this.length <= length;
}



function validate(rules, validationMessages){

	var errors = {};
	for (var selector in rules){

		var functions = [], pass = 'value', empty = false;
		if (rules[selector] instanceof Array){
			functions = rules[selector];
		} else {
			functions = rules[selector].rules;
			if (typeof rules[selector].pass != 'undefined'){
				pass = rules[selector].pass;
			}

			if (typeof rules[selector].empty != 'undefined'){
				empty = rules[selector].empty;
			}
		}
		$.each(functions, function(i, func){
			var fields = $(selector);

			fields.removeClass('form-error');
			fields.each(function(idx){
				if (typeof errors[selector +':nth(' + idx + ')'] == 'undefined'){
					var value = this.value;
					if (pass == 'selector'){
						value = this;
					}

					var result = false, rule = '';

					if (typeof func == 'object'){
						if (!(func.value instanceof Array)){
							func.value = [func.value];
						}

						result = (empty && !notEmpty(this.value)) || window[func.rule].apply(value, func.value);
						rule = func.rule;
					} else {
						result = (empty && !notEmpty(this.value)) || window[func](value);
						rule = func;
					}

					if (!result){

						var message = validationMessages[rule];
						if (typeof func == 'object' && func.value){
							message = message.replace(':value', func.value);
						}

						errors[selector +':nth(' + idx + ')'] = message;
					}
				}
			});
		});
	}

	//$('.error-message').hide();
	$('.error:input').removeClass('error');

	$.each(errors, function(selector, message){
		
		$(selector).addClass('form-error')
		.parent()
		.append($('<div>', {
			'class': 'error-message error_'+$(selector).attr('id')
		}).text(message));

	//		$(selector).change(function(){
	//			validate(rules, validationMessages);
	//		});
	});

	var firstError = $('.form-error:input:first');
	var errorParent = firstError.parents('.tabs-box');
	if (errorParent.length){
		activateTab('#' + errorParent.attr('id'));
	}
	firstError.focus();

	return $.isEmptyObject(errors);
}




 function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}