<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Urban Postcode Finder</h3>
    </div>
    <div class="panel-body">
    	<form class="form-horizontal" role="form" method="POST" action="">
    		{{ csrf_field() }}
    		<div class="form-group" id="npc-up-state">
                <label for="up-state" class="col-md-4 control-label">State</label>
                <div class="col-md-6">
                    <select class="form-control" id="up-state-select" name="up-state">
                        <option value="">Select State</option>
                    </select>

                    <div id="up-state-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>

             <div id="npc-up-town" class="form-group npc-hidden">
    			<label for="up-town" class="col-md-4 control-label">Town</label>
    			<div class="col-md-6">
                    <select class="form-control" id="up-town-select" name="up-town">
                        <option value="">Select Urban Town</option>
                    </select>
                    <div id="up-town-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>

             <div id="npc-up-area" class="form-group npc-hidden">
    			<label for="up-area" class="col-md-4 control-label">Area</label>
    			<div class="col-md-6">
                    <select class="form-control" id="up-area-select" name="up-area">
                        <option value="">Select Urban Area</option>
                    </select>
                    <div id="up-area-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>

             <div id="npc-up-street" class="form-group npc-hidden">
    			<label for="up-street" class="col-md-4 control-label">Street</label>
    			<div class="col-md-6">
                    <select class="form-control" id="up-street-select" name="up-street">
                        <option value="">Select Street</option>
                    </select>
                    <div id="up-street-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>

            <!--
             <div id="npc-up-street" class="form-group npc-hidden">
    			<label for="up-street" class="col-md-4 control-label">Street</label>
    			<div class="col-md-6">
                    <div class="up-street-input-wrapper">
                        <input class="form-control" name="up-street" id="up-street-input" type="text" placeholder="Start typing the Street name" autocomplete="off">
                        <div id="up-street-menu" class="up-street-menu npc-hidden" role="menu">
                        
                        </div>
                    </div>
                </div>
             </div> -->

    	</form>
    	<!-- spinner -->
        <div id="up-loading" class="npc-spinner-medium npc-hidden"></div>
    </div>
    <div id="up-result" class="panel-footer npc-hidden">
        <p><strong><span id="up-result-street"></span></strong> in <strong><span id="up-result-town"></span></strong> town <span id="up-result-relationship"></span>:</p>
        <ul id="up-result-postcodes"></ul>
    </div>
</div>
