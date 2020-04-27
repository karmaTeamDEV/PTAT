        <footer>
        
          <div>
         	<span> Best viewed in latest version of Chrome </span>
             <span class="pull-right">Path To Agility® &copy; <?php echo date("Y");?> </span>
          </div>
          <div class="clearfix"></div>
        </footer>


        
    <!-- FastClick -->
    <script src="<?php echo base_path;?>design/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_path;?>design/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_path;?>design/vendors/iCheck/icheck.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_path;?>design/build/js/custom.js"></script>
   
    <script src="<?php echo base_path;?>design/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- bootstrap-datetimepicker -->    
    <script src="<?php echo base_path;?>design/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    
    <!-- Datatables -->
    <script src="<?php echo base_path;?>design/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo base_path;?>design/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_path;?>design/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="<?php echo base_path;?>design/build/js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="<?php echo base_path;?>design/build/js/bootbox.js"></script>
    <script>
    $('#myDatepicker').datetimepicker();
    
    $('#myDatepicker1').datetimepicker({
        format: 'MM/DD/YYYY'
    });
    
    $('#myDatepicker2').datetimepicker({
        format: 'MM/DD/YYYY'
    });
    
    $('#myDatepicker3').datetimepicker({
        format: 'MM/DD/YYYY'
    });
    
    $('#myDatepicker4').datetimepicker({
        format: 'MM/DD/YYYY'
    });
    
    $('.onlyDatepicker').datetimepicker({
        format: 'MM/DD/YYYY'
    });
    
    $('#myDatepicker3').datetimepicker({
        format: 'hh:mm A'
    });
    
    $('#myDatepicker4').datetimepicker({
        ignoreReadonly: true,
        allowInputToggle: true
    });

    $('#datetimepicker6').datetimepicker();
    
    $('#datetimepicker7').datetimepicker({
        useCurrent: false
    });
    
    $("#datetimepicker6").on("dp.change", function(e) {
        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
    });
    
    $("#datetimepicker7").on("dp.change", function(e) {
        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    }); 

  $(document).ready(function() {
    $('.tbl_data').DataTable({
       "pageLength": 10
       });
    setTimeout(function() { $(".alert-danger").slideUp(1000); }, 2500);
  }); 


  function dt_convert(dt){
            var mydate = new Date(dt);
            //var curr_date = mydate.getDate();
            var curr_date = mydate.getDate().toString();
            curr_date = curr_date.length > 1 ? curr_date : '0' + curr_date;

            //var curr_month = mydate.getMonth() + 1; //Months are zero based
             var curr_month = (1 + mydate.getMonth()).toString();
             curr_month = curr_month.length > 1 ? curr_month : '0' + curr_month;

            var curr_year = mydate.getFullYear();
            return curr_month +"/"+ curr_date +"/"+curr_year; 
  } 

  function getFormattedDate(date) {
      var year = date.getFullYear();

      var month = (1 + date.getMonth()).toString();
      month = month.length > 1 ? month : '0' + month;

      var day = date.getDate().toString();
      day = day.length > 1 ? day : '0' + day;
      
      return month + '/' + day + '/' + year;
} 


function datetimeFormat(dt){
            var mydate = new Date(dt);
            //var curr_date = mydate.getDate();
            var curr_date = mydate.getDate().toString();
            curr_date = curr_date.length > 1 ? curr_date : '0' + curr_date;

            //var curr_month = mydate.getMonth() + 1; //Months are zero based
             var curr_month = (1 + mydate.getMonth()).toString();
             curr_month = curr_month.length > 1 ? curr_month : '0' + curr_month;

            var curr_year = mydate.getFullYear();

            var hours = mydate.getHours().toString();
            hours = hours.length > 1 ? hours : '0' + hours;

            var minute = mydate.getMinutes().toString();
            minute = minute.length > 1 ? minute : '0' + minute;

            var second = mydate.getSeconds().toString();
            second = second.length > 1 ? second : '0' + second;  

           return curr_month +"/"+ curr_date +"/"+curr_year+' '+hours+':'+minute+':'+second;
           // return curr_month +"/"+ curr_date +"/"+curr_year; 
  } 
  function timeDiffCalc(dateFuture, dateNow) {
      let diffInMilliSeconds = Math.abs(dateFuture - dateNow) / 1000;

      // calculate days
      // const days = Math.floor(diffInMilliSeconds / 86400);
      // diffInMilliSeconds -= days * 86400;
      //console.log('calculated days', days);

      // calculate hours
      const hours = Math.floor(diffInMilliSeconds / 3600) % 24;
      diffInMilliSeconds -= hours * 3600;
      //console.log('calculated hours', hours);

      // calculate minutes
      const minutes = Math.floor(diffInMilliSeconds / 60) % 60;
      diffInMilliSeconds -= minutes * 60;
      //console.log('minutes', minutes);

      
      let difference = '';
      // if (days > 0) {
      //   difference += (days === 1) ? `${days} day, ` : `${days} days, `;
      // }

      difference += (hours === 0 || hours === 1) ? `${hours} hour, ` : `${hours} hours, `;

      difference += (minutes === 0 || hours === 1) ? `${minutes} minutes, ` : `${minutes} minutes, `; 

      difference +=   diffInMilliSeconds +' seconds';

      return difference;
  }




 $.cookie('idleTime', 0, { expires: 1, path: '/' });
$(document).ready(function() {
    //alert(1);
    var idleInterval = setInterval("timerIncrement()", 150000); // 1 minute //60000
    $(this).mousemove(function(e) {

        $.cookie('idleTime', 0, { expires: 1, path: '/' });
        //alert(2);
    });
    $(this).keypress(function(e) {

        $.cookie('idleTime', 0, { expires: 1, path: '/' });
        //alert(3);
    });

});

function timerIncrement() {
     //alert(4);
    $.cookie('idleTime', parseInt($.cookie('idleTime'))+1, { expires: 1, path: '/' });
    
   // alert($.cookie('idleTime')+'===');
    
    if ($.cookie('idleTime') >= 11) {
        
        $.removeCookie('idleTime', { path: '/' });
        
        window.location = '<?php echo base_url();?>index.php/Member/logout';
    }
}

function set_time_zone_print(get_time, get_zone)
{
 
  if(get_time!=""){
    var x=get_time.split('-').join('/');     
    var d=new Date(x+" "+get_zone);    
    return datetimeFormat(d.toString().slice(3, 25));
  }else{  
    return ' ';
  }

}


	
</script>



