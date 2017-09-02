console.log('Include LS.js');
;(function (root, factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD module
		define(factory);
	} else if (typeof exports === 'object') {
		// CommonJS-like environment (i.e. Node)
		module.exports = factory();
	} else {
		// Browser global
		root.LS = factory();
	}
}(this || window, function () {
	'use strict';
	var _ = {
		set: function(name,data){ localStorage.setItem(name,JSON.stringify(data) ); },
		get: function(name){ return JSON.parse( localStorage.getItem(name) ); },
		clear: function(){ localStorage.clear(); location.reload(); }
	};
	return _;
}));
