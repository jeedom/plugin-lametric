<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('lametric');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">
     <div class="col-lg-12 eqLogicThumbnailDisplay">
   <legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
   <div class="eqLogicThumbnailContainer">
	<div class="cursor eqLogicAction logoPrimary" data-action="add">
		<i class="fas fa-plus-circle"></i>
		<br/>
		<span>{{Ajouter}}</span>
	</div>
	<div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
		<i class="fas fa-wrench"></i>
		<br/>
		<span >{{Configuration}}</span>
	</div>
  </div>
        <legend><i class="techno-cable1"></i> {{Mes lametrics}}</legend>
	 <input class="form-control" placeholder="{{Rechercher}}" id="in_searchEqlogic" />
            <div class="eqLogicThumbnailContainer">
                <?php
                foreach ($eqLogics as $eqLogic) {
					$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                    echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
					echo '<img src="plugins/lametric/docs/images/lametric_icon.png" height="105" width="95" />';	
                    echo "<br>";
                    echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
                    echo '</div>';
                }
                ?>
            </div>
    </div>
    <div class="col-lg-12 eqLogic" style="display: none;">
	   	<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-default eqLogicAction btn-sm roundedLeft" data-action="configure"><i class="fas fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a class="eqLogicAction cursor" aria-controls="home" role="tab" data-action="returnToThumbnailDisplay"><i class="fas fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-list-alt"></i> {{Commandes}}</a></li>
		</ul> 
	    	<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
        <div class="row">
        	<div class="col-sm-6">
		        <form class="form-horizontal">
		            <fieldset>
		                <legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}<i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i></legend>
		                <div class="form-group">
		                    <label class="col-lg-2 control-label">{{Nom de l'équipement lametric}}</label>
		                    <div class="col-lg-4">
		                        <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
		                        <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement lametric}}"/>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-lg-2 control-label" >{{Objet parent}}</label>
		                    <div class="col-lg-4">
		                        <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
		                            <option value="">{{Aucun}}</option>
		                            <?php
		                            foreach (jeeObject::all() as $object) {
		                                echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
		                            }
		                            ?>
		                        </select>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="col-lg-2 control-label">{{Catégorie}}</label>
		                    <div class="col-lg-8">
		                        <?php
		                        foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
		                            echo '<label class="checkbox-inline">';
		                            echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
		                            echo '</label>';
		                        }
		                        ?>
		
		                    </div>
		                </div>
		                <div class="form-group">
					        <label class="col-sm-2 control-label"></label>
					        <div class="col-sm-6">
					          <input type="checkbox" class="eqLogicAttr" data-label-text="{{Activer}}" data-l1key="isEnable" checked/>Activer
					          <input type="checkbox" class="eqLogicAttr" data-label-text="{{Visible}}" data-l1key="isVisible" checked/>Visible
					        </div>
					  </div>
		            </fieldset>
					  <fieldset>
		                <legend>{{Options pour les notifications}}</legend>

					  <div class="form-group">
			            <label class="col-sm-3 control-label">{{Local IP}}</label>
			            <div class="col-sm-5">
			              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="localip" placeholder="Local IP"/>
			            </div>
			          </div>
			          <div class="form-group">
			            <label class="col-sm-3 control-label">{{Token API}}</label>
			            <div class="col-sm-5">
			              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="tokenapi" placeholder="Token API"/>
			            </div>
					  </div>
					  </fieldset>
					  <fieldset>
					  <legend>{{Options pour une application 'indicator'}}</legend>
					  <div class="form-group">
			            <label class="col-sm-3 control-label">{{Push URL}}</label>
			            <div class="col-sm-5">
			              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="pushurl" placeholder="Push URL"/>
			            </div>
			          </div>
			          <div class="form-group">
			            <label class="col-sm-3 control-label">{{Token Access}}</label>
			            <div class="col-sm-5">
			              <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="token" placeholder="Token Access"/>
			            </div>
			          </div>
		            </fieldset> 
		        </form>
			</div>
			<div class="col-sm-6">
				<legend><i class="fa fa-info"></i>  {{Informations}}</legend>
                 <div class="form-group">	
                    <div style="text-align: center">
                     	<center><img src="plugins/lametric/docs/images/lametric_icon.png" id="img_Model"  onerror="this.src='plugins/lametric/docs/images/lametric_icon.png'" style="height : 280px;" /></center>
                    </div>
               	</div>
			</div>
		</div>		       

       	</div>
			<div role="tabpanel" class="tab-pane" id="commandtab">
				<br/>
        <table id="table_cmd" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th style="width: 200px;">{{Nom}}</th>
                    <th style="width: 100px;">{{Type}}</th>
                    <th style="width: 200px;">{{Options}}</th>
                    <th style="width: 100px;"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
	</div>
	    </div>
</div>
<?php include_file('desktop', 'lametric', 'js', 'lametric'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>
