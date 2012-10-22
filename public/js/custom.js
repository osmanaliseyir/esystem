//JS document
$(function(){
$(".ttip").tipsy();
$('input[placeholder], textarea[placeholder]').placeholder();
});

function today(){
   var d=new Date();
   var monthNames= new Array("Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Agustos","Eylül","Ekim","Kasım","Aralık");
   var dayNames= new Array("Pazar","Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi");
   var today   = (d.getDate()<10 ? '0' : '')+d.getDate()+" "+ monthNames[d.getMonth()]+" "+d.getFullYear()+" <b>"+dayNames[d.getDay()]+"</b>";
   return today;
}
   
function changeFontSize(change,elId){
   var Container = document.getElementById(elId);
   if(change=="-1" && parseInt(Container.style.fontSize)>10 )
      Container.style.fontSize=(parseInt(Container.style.fontSize)-2)+"px";
    else if(change=="+1" && parseInt(Container.style.fontSize)<20)
      Container.style.fontSize=(parseInt(Container.style.fontSize)+2)+"px"; 
    else if(change==0)
       Container.style.fontSize="12px";
}

function isEmail(value){
   var reg=new RegExp(/^[a-z]{1}[\d\w\.-]+@[\d\w-]{3,}\.[\w]{2,3}(\.\w{2})?$/);
   return reg.test(value);
}

function isNumeric(evt){
   var charCode= (evt.which) ? evt.which : event.keyCode
   if(charCode >31 && (charCode<48 || charCode>57))
      return false;
   else 
      return true;
}

function resultFormat(type,text){
   var str="<div class='"+type+"'>"+text+"</div>";
   return str;
}

function checkAll(){
   if($("#checkVal").val()=="0"){
      $("input[name^='sec']").attr("checked","checked");
      $("#checkVal").val("1");
   } else {
      $("input[name^='sec']").removeAttr("checked");
      $("#checkVal").val("0");
   }   
}