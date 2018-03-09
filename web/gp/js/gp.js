/**
 * Created by Yangzhe on 2018/3/7.
 */

$('#search').blur(function(){
   var value = $('#search').val();
   var url = $('#search').attr('url');
   window.location.href=url+'?search='+value;
});