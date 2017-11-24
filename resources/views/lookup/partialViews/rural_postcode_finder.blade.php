<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Rural Postcode Finder</h3>
    </div>
    <div class="panel-body">
    	<form class="form-horizontal" role="form" method="POST" action="">
    		{{ csrf_field() }}
    		<div class="form-group" id="npc-rp-state">
                <label for="rp-state" class="col-md-4 control-label">State</label>
                <div class="col-md-6">
                    <select class="form-control" id="rp-state-select" name="rp-state">
                        <option value="">Select State</option>
                    </select>

                    <div id="rp-state-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>

             <div id="npc-rp-lga" class="form-group npc-hidden">
             	<label for="rp-lga" class="col-md-4 control-label">LGA</label>
             	<div class="col-md-6">
                    <select class="form-control" id="rp-lga-select" name="rp-lga">
                        <option value="">Select LGA</option>
                    </select>
                    <div id="rp-lga-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>

             <div id="npc-rp-area" class="form-group npc-hidden">
             	<label for="rp-area" class="col-md-4 control-label">Area</label>
             	<div class="col-md-6">
                    <select class="form-control" id="rp-area-select" name="rp-area">
                        <option value="">Select Rural Area</option>
                    </select>
                    <div id="rp-area-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>

             <div id="npc-rp-village" class="form-group  npc-hidden">
    			<label for="rp-village" class="col-md-4 control-label">Village</label>
    			<div class="col-md-6">
                    <select class="form-control" id="rp-village-select" name="rp-village">
                        <option value="">Select Village</option>
                    </select>
                    <div id="rp-village-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>
    	</form>
    	<!-- spinner -->
        <div id="rp-loading" class="npc-spinner-medium npc-hidden"></div>
    </div>
    <div id="rp-result" class="panel-footer npc-hidden">
        <p><strong><span id="rp-result-village"></span></strong> village in <strong><span id="rp-result-lga"></span></strong> LGA <span id="rp-result-relationship"></span>:</p>
        <ul id="rp-result-postcodes"></ul>
    </div>
</div>
