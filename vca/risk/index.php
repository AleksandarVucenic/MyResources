<script src="/managetpc/risk/js/risk.js"></script>
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/prog_head.php");
?>

<fieldset>
    <table width="935">
        <tbody>

            <tr>
                <td>
                    <fieldset><legend><h3>Risk Classification</h3></legend> 

                        <div id="riskClassificationFormDiv" style="display: none;">
                            <form id="riskClassificationForm" name="riskClassificationForm" novalidate onsubmit="return false;">
                                <!-- RISC CLSIFICATION FORM -->
                                <table>

                                    <tr>
                                        <td><label> Risk Name: </label></td>
                                        <td><input type="text" name="riskNameForm" id="riskNameForm" value="" required/></td>
                                    </tr>

                                    <tr>
                                        <td><label> Risk Level Name: </label></td>
                                        <td><input type="text" name="riskLevelForm" id="riskLevelForm" value="" required/></td>
                                    </tr>

                                    <tr>
                                        <td><label> Risk value: </label></td>

                                        <td>
                                            <input type="range" name="riskValueForm" id="riskValueForm"  min="0" max="100" value="0" oninput="updateSlider(this.value,'#riskValueOutput')" style="width: 180px;margin-right: 10px;" >
                                            <output for="riskValueForm" name="riskValueOutput" id="riskValueOutput"></output>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td><label> Risk cost: </label></td>
                                        <td>
                                            <select id="riskCostGradeForm" name="riskCostGradeForm" style="width: 35px;">
                                                <option value=">"> > </option>
                                                <option vlaue="<"> < </option>
                                                <option vlaue="<="> <= </option>
                                                <option vlaue=">="> >= </option>
                                                <option vlaue="="> = </option>
                                            </select>
                                            <input type="text" name="riskCostForm" id="riskCostForm" style="width: 95px;" value="" required/> 
											<?php listValues("tdbCurrency", "currencyID", "currencyName", $lines = "1", $trigger = "", "", $orderby = "currencyName", $class = "w60", $info = false, $where = "currencyID not like 3",  @$currencyID); ?>
							
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label> Risk Classification Color: </label></td>
                                        <td><input type="color" name="riskColorForm" id="riskColorForm" value="#FFFFFF" /></td>
                                    </tr>

                                    <tr>
                                        <td><label> Risk Comment: </label></td>
                                        <td><textarea name="riskCommentForm" id="riskCommentForm" ></textarea></td>
                                    </tr>

                                </table>
                                </br>
                                <input id="riskSaveForm" type="submit" name="save" value="Save"       
                                       onclick="submitAjaxForm('/managetpc/risk/ajax/definition/riskClassificationLogic.php?action=save', '#riskClassificationForm', '', true, '', true);
                                                                        getRiskClassificationTable('#riscClassificationTable');
                                                                        clearForm('#riskClassificationForm');
                                                                        hideIt('#riskClassificationFormDiv');" 
                                       />

                                <input id="riskUpdateForm" type="submit" name="update" value="Update"       
                                       onclick="submitAjaxForm('/managetpc/risk/ajax/definition/riskClassificationLogic.php?action=update', '#riskClassificationForm', '', true, '', true);
                                                                        getRiskClassificationTable('#riscClassificationTable');
                                                                        clearForm('#riskClassificationForm');
                                                                        hideIt('#riskClassificationFormDiv');" 
                                       />
                                <input type="hidden" name="riskIDForm" id="riskIDForm" value="" /> 
                                <input type="button" value="Close Form" onclick="hideIt('#riskClassificationFormDiv')" />
                            </form>
                            </br></br></br>
                        </div>


                        <div class="add_new" style="text-align: right;">
                            <a onclick="addRiskClassificatoin()" > Add Classification </a>	
                        </div>
                        </br>
                        <!-- SHOW DEFINITION RISK -->

                        <div id="riscClassificationTable"></div>



                    </fieldset>	
                </td>


            </tr>

            <tr>
                <td>
                    <!-- ***** RISK TYPE ***** -->
                    <fieldset><legend><h3> Risk Items Types </h3></legend> 
                        <div id="riskTypeFormDiv" style="display: none;">
                            <form id="riskTypeForm" name="riskTypeForm" novalidate onsubmit="return false;">
                                <!-- RISC TYPE FORM -->
                                <table>

                                    <tr>
                                        <td><label> Type Name: </label></td>
                                        <td><input type="text" name="riskTypeNameForm" id="riskTypeNameForm" value="" required/></td>
                                    </tr>

                                    <tr>
                                        <td><label> Type Coef.: </label></td>
                                        <td><input type="text" name="riskTypeCoefForm" id="riskTypeCoefForm" value="" required/></td>
                                    </tr>

                                    <tr>
                                        <td><label> Type Normal Ratio: </label></td>
                                        <td>
                                            <input type="range" name="riskTypeNormalRatioForm" id="riskTypeNormalRatioForm"  min="0" max="100" value="0" style="width: 180px;margin-right: 10px;" oninput="updateSlider(this.value,'#riskNormalRatioOutput')">
                                            <output for="riskNormalRatioOutput" id="riskNormalRatioOutput"></output>
                                        </td>
                                    </tr>

                                </table>
                                </br>

                                <input id="riskTypeSaveForm" type="submit" name="save" value="Save"       
                                       onclick="submitAjaxForm('/managetpc/risk/ajax/definition/riskTypeLogic.php?action=save', '#riskTypeForm', '', true, '', true);
                                                                        getRiskTypeTable('#riskTypeTable');
                                                                        clearForm('#riskRiskForm');
                                                                        hideIt('#riskTypeFormDiv');" 
                                       />

                                <input id="riskTypeUpdateForm" type="submit" name="update" value="Update"       
                                       onclick="submitAjaxForm('/managetpc/risk/ajax/definition/riskTypeLogic.php?action=update', '#riskTypeForm', '', true, '', true);
                                                                        getRiskTypeTable('#riskTypeTable');
                                                                        clearForm('#riskTypeForm');
                                                                        hideIt('#riskTypeFormDiv');" 
                                       />
                                <input type="hidden" name="riskTypeIDForm" id="riskTypeIDForm" value="" />

                                <input type="button" value="Close Form" onclick="hideIt('#riskTypeFormDiv')" />
                            </form>
                            </br></br></br>
                        </div>



                        <div class="add_new" style="text-align: right;">
                            <a onclick="addRiskType('#riskTypeFormDiv')" > Add Risk Type</a>	
                        </div>
                        </br>

                        <div id="riskTypeTable"></div>




                    </fieldset>	
                </td>
            </tr>



            <!-- ============== LIKELIHOOD SCALE ====================== -->
            <tr>
                <td>
                    <!-- ***** RISK LIKELIHOOD ***** -->
                    <fieldset><legend><h3> Risk Likelihood</h3></legend> 
                        <div id="riskLikelihoodFormDiv" style="display: none;">
                            <form id="riskLikelihoodForm" name="riskLikelihoodForm" novalidate onsubmit="return false;">
                                <!-- RISC LIKELIHOOD FORM -->
                                <table>
                                    <tr>
                                        <td><label> Likelihood Scake: </label></td>
                                        <td>
                                            From:            <input type="text" name="riskLikelihoodFromForm" id="riskLikelihoodFromForm" style="width: 125px;" value="" /> years</br>
                                            To: &nbsp;&nbsp; <input type="text" name="riskLikelihoodToForm"   id="riskLikelihoodToForm"   style="width: 125px;" value="" /> years
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label> Likelihood Notes: </label></td>
                                        <td><textarea type="text" name="riskLikelihoodNotes" id="riskLikelihoodNotes" value="" ></textarea></td>
                                    </tr>

                                    <tr>
                                        <td><label> Likelihood Percente: </label></td>
                                        <td>
                                            <input type="range" name="riskLikelihoodPercenteForm" id="riskLikelihoodPercenteForm"  min="0" max="100" value="0" style="width: 180px;margin-right: 10px;" oninput="updateSlider(this.value,'#riskLikelihoodPercenteOutput')" >
                                            <output for="riskLikelihoodPercente" id="riskLikelihoodPercenteOutput"></output>
                                        </td>
                                    </tr>

                                </table>
                                </br>

                                <input id="riskLikelihoodSaveForm" type="submit" name="save" value="Save"       
                                       onclick="submitAjaxForm('/managetpc/risk/ajax/definition/riskLikelihoodLogic.php?action=save', '#riskLikelihoodForm', '', true, '', true);
                                                                        getRiskLikelihoodTable('#riskLikelihoodTable');
                                                                        clearForm('#riskLikelihoodForm');
                                                                        hideIt('#riskLikelihoodFormDiv');" 
                                       />

                                <input id="riskLikelihoodUpdateForm" type="submit" name="update" value="Update"       
                                       onclick="submitAjaxForm('/managetpc/risk/ajax/definition/riskLikelihoodLogic.php?action=update', '#riskLikelihoodForm', '', true, '', true);
                                                                        getRiskLikelihoodTable('#riskLikelihoodTable');
                                                                        clearForm('#riskLikelihoodForm');
                                                                        hideIt('#riskLikelihoodFormDiv');" 
                                       />

                                <input type="hidden" name="riskLikelihoodIDForm" id="riskLikelihoodIDForm" value="" />
                                <input type="button" value="Close Form" onclick="hideIt('#riskLikelihoodFormDiv')" />
                            </form>
                            </br></br></br>
                        </div>



                        <div class="add_new" style="text-align: right;">
                            <a onclick="addRiskLikelihood('#riskLikelihoodFormDiv')" > Add Likelihood</a>	
                        </div>
                        <br>
                        <div id="riskLikelihoodTable"></div>
                        
                        <!-- SHOW LIKELIHOOD RISK -->



                    </fieldset>	
                </td>
            </tr> 




        </tbody>
    </table> 

    </br></br>

</fieldset>

<script>
    getRiskClassificationTable('#riscClassificationTable');
    getRiskTypeTable('#riskTypeTable');
    getRiskLikelihoodTable('#riskLikelihoodTable');
</script>