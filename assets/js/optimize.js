/**
 * Optimasi untuk loading tiap halaman
 */
(function(){
  var deferred;
 
  $(document).on('click', '.show-scores', setupOnce(function(){
    // $.getJSON returns a $.Deferred object
    deferred = $.getJSON('/scores.json');
  }, function() {
    deferred.done(function(json) {
      // fancy score handling
    });
  }));
})();
 
/**
 * Prepare a modal box or a template once and fill it in at each invocation
 */
(function(){
  var modal;
 
  $(document).on('click', '.modal-trigger', setupOnce(function(){
      modal = new Modal();
  }, function() {
      modal.title = this.source.title;
      modal.show();
  }));
})();