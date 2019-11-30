/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-play': '&#xe91c;',
		'icon-fa-sliders-h': '&#xe91b;',
		'icon-hamburger': '&#xe900;',
		'icon-check': '&#xe901;',
		'icon-container-outlined': '&#xe902;',
		'icon-heading': '&#xe903;',
		'icon-gem': '&#xe904;',
		'icon-times-circle': '&#xe905;',
		'icon-plus': '&#xe906;',
		'icon-angle-up': '&#xe907;',
		'icon-angle-down': '&#xe908;',
		'icon-angle-left': '&#xe909;',
		'icon-user-o': '&#xe90a;',
		'icon-info-o': '&#xe90b;',
		'icon-magnifier': '&#xe90c;',
		'icon-twitter': '&#xe90d;',
		'icon-facebook-f': '&#xe90e;',
		'icon-edit': '&#xe90f;',
		'icon-heart': '&#xe910;',
		'icon-colorscheme': '&#xe911;',
		'icon-containers': '&#xe912;',
		'icon-font': '&#xe913;',
		'icon-user-edit': '&#xe914;',
		'icon-shield': '&#xe915;',
		'icon-eye': '&#xe916;',
		'icon-minus': '&#xe917;',
		'icon-google': '&#xe918;',
		'icon-download': '&#xe919;',
		'icon-refresh': '&#xe91a;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
