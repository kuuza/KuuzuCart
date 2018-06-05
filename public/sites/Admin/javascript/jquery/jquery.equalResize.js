/**
 * Equal Resize jQuery Plugin
 *
 * @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
 */

(function( $ ){
  $.fn.equalResize = function() {
    return this.each(function() {
      var widest = 0;
      var highest = 0;

      $(this).children().each(function() {
        widest = Math.max(widest, $(this).width());
        highest = Math.max(highest, $(this).height());
      }).width(widest).height(highest);
    });
  };
})( jQuery );
