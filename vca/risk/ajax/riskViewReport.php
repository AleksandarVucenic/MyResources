
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
include($_SERVER['DOCUMENT_ROOT'] . "/managetpc/risk/helpers/functions.php");
//var_dump($_GET['siteID'])
?>

<link href="/style/example.css" rel="stylesheet" type="text/css"/>
<link href="/style/graphStyle.css" rel="stylesheet" type="text/css"/>
<script src="/js/flot/jquery.flot.min.js"></script>
<script src="/js/flot/jquery.flot.time.js"></script>
<script src="/js/flot/jquery.flot.categories.min.js"></script>
<script src="/js/flot/jquery.flot.selection.js"></script>
<script src="/js/flot/jquery.flot.threshold.js"></script>
<script src="/js/formValidator.js"></script>
<script src="/js/datetimepicker_css.js"></script>
<script src="/managetpc/risk/js/risk.js"></script>
<script src="/js/flot/flot.js"></script>
<script src="/js/jqueryprint.js"></script>
<script>

    
    function printCanvas(el) {  
        var canvas = $(el)[0];
        var img = canvas.toDataURL("image/png");

        $("body").append('<img src="'+img+'"/>');
    }
    
    
    function PrintElem(elem)
    {
        

        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var can = $('.flot-base')[0];
        var dataUrl = can.toDataURL("image/png");
        $(".graph-lines").append(dataUrl);
        var mywindow = window.open('', 'Graph', 'height=800,width=600');
        mywindow.document.write('<html><head><title>Graph Data</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('<img style="margin-top: -0px;" src="' + dataUrl + '">');
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();
        
        return true;
    }


</script>
<div class="container_6 horizontal_menu" style=" box-shadow: none; margin-bottom: -10px;" >
    <div id="menu">
        <div class="tab"><a onclick="viewReports('assets');" >      <span style="padding-left: 0;"> Assets       </span></a></div>
        <div class="tab"><a onclick="viewReports('employee');" >    <span style="padding-left: 0;"> Employee     </span></a></div>
        <div class="tab"><a onclick="viewReports('stakeholders');"> <span style="padding-left: 0;"> Stakeholder  </span></a></div>
        <div class="tab"><a onclick="viewReports('vendor');" >    <span style="padding-left: 0;"> Contract     </span></a></div>
        <div class="tab"><a onclick="viewReports('sla');" >         <span style="padding-left: 0;"> SLA          </span></a></div>
        <div class="tab"><a onclick="viewReports('applications');"> <span style="padding-left: 0;"> Applications </span></a></div>
        <div class="tab"><a onclick="viewReports('site');" >     <span style="padding-left: 0;"> Global       </span></a></div>
    </div>
</div>

<table background="white">

    <tr>
        <td>
            <fieldset>
                </br>
                <!--fieldset>
                        <legend> Migration info </legend>
                        
                        
                        
                        <table width="905">
                                <tr class="table_header">
                                        <td align="center"> Full Node Name </td>
                                        <td align="center"> OS Class       </td>
                                        <td align="center"> System Status  </td>
                                        <td align="center"> Sys. Type      </td>
                                        <td align="center"> Migration Risk </td>
                                </tr>
                                <tr>
                                        <td align="center"> Full Node Name </td>
                                        <td align="center"> OS Class       </td>
                                        <td align="center"> System Status  </td>
                                        <td align="center"> Sys. Type      </td>
                                        <td align="center"> Migration Risk </td>
                                </tr>
                        </table>
                </fieldset-->

                </br>

                <fieldset id="graph-container">
                    <legend>Graph </br></legend>






                    <div id="header">
                       
                    </div>





                    <!--div id="content">
                        <div class="demo-container" style="width: 800px; height: 400px;">
                                <div id="placeholder" class="demo-placeholder" ></div>
                        </div>
            
                    </div-->
                    <div id="risk-report"  ></div>
                    <div id="graph-wrapper">

                        <div class="graph-info">
                            <!--a href="javascript:void(0)" class="legend-item">  Assets       </a>
                            <a href="javascript:void(0)" class="legend-item">  Employee     </a>
                            <a href="javascript:void(0)" class="legend-item">  Stakeholder  </a>
                            <a href="javascript:void(0)" class="legend-item">  Contract     </a>
                            <a href="javascript:void(0)" class="legend-item">  SLA          </a>
                            <a href="javascript:void(0)" class="legend-item">  Applications </a>

                            <a href="#" id="bars"><span></span></a>
                            <a href="#" id="lines" class="active"><span></span></a-->
                            
                            

                        </div></br>

                        
                        <a id="reset-graph-line" stype="margin: 0px 0px 0px 30px;" onclick="viewReports('assets')" >Reset Graph</a>
                        <div class="graph-container"> 
                            <div id="graph-lines"></div>
                            <div id="graph-bars"></div>
                            
                            
                        </div>
                        <input type="button" onclick="PrintElem('.graph-container');" value="Print Graph" />
                        <div id="overview" class="demo-placeholder" style="float:right;width:160px; height:125px;"></div>


                        <!--table style="margin: 10px auto;">
                            <tr>
                                <td>			
                                    <label>From: </label>
                                    <input name="migrationLikelihoodFrom" id="migrationLikelihoodFrom" type="text" value="" readonly="readonly"  style="width: 100px;" />
                                    <img src="/images/calendarImages/cal.gif" id="start" onclick="javascript:NewCssCal('migrationLikelihoodFrom', 'ddmmyyyy', 'dropdown', false, '24')" />
                                </td>

                                <td>
                                    <label>To: &nbsp;&nbsp;</label>
                                    <input name="migrationLikelihoodTo" id="migrationLikelihoodTo" type="text" value="" readonly="readonly" style="width: 100px;" />
                                    <img src="/images/calendarImages/cal.gif" id="end"   onclick="javascript:NewCssCal('migrationLikelihoodTo', 'ddmmyyyy', 'dropdown', false, '24')" />
                                </td>
                                <td>
                                    <!input  type="button" value="Show Graph" onclick="viewReports('assets')" />		
                                </td>
                            </tr>

                        </table-->

                    </div>


                    
                    
                    

                </fieldset>

            </fieldset>


        </td>
    </tr>


    <tr>
        <td>

        </td>
    </tr>

</table>	

<script>
    viewReports('assets');
</script>












