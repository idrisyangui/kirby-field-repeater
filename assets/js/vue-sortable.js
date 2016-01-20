( function() {

  "use strict"

  var VueSortable = {},
      Sortable = typeof require === "function" ? require( "sortablejs" ) : window.Sortable;

  VueSortable.install = function( Vue ) {
    Vue.directive( "sortable", function( value ) {
      var vm = this.vm,
          key = this.arg,
          array = vm[ key ];

      // TODO: need to copy deeply?
      value = value || {};

      value.onUpdate = function( e ) {
        var target = array[ e.oldIndex ];
        array.$remove( target );
        array.splice( e.newIndex, 0, target );
        vm.$emit( "sort", target, e );
      };

      this.el.sortable = Sortable.create( this.el, value );
    });
  };

  if ( typeof exports === "object" ) {
    module.exports = VueSortable;
  } else if ( typeof define === "function" && define.amd ) {
    define( [ ], function() { return VueSortable; } );
  } else if ( window.Vue ) {
    window.VueSortable = VueSortable;
    Vue.use( VueSortable );
  }
})();