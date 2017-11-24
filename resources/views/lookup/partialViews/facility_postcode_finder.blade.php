<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Facility Postcode Finder</h3>
    </div>
    <div class="panel-body">
    	<form class="form-horizontal" role="form" method="POST" action="">
    		{{ csrf_field() }}
    		<div class="form-group" id="npc-fp-state">
                <label for="fp-state" class="col-md-4 control-label">State</label>
                <div class="col-md-6">
                    <select class="form-control" id="fp-state-select" name="fp-state">
                        <option value="">Select State</option>
                    </select>

                    <div id="fp-state-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>

             <div id="npc-fp-lga" class="form-group npc-hidden">
             	<label for="fp-lga" class="col-md-4 control-label">LGA</label>
             	<div class="col-md-6">
                    <select class="form-control" id="fp-lga-select" name="fp-lga">
                        <option value="">Select LGA</option>
                    </select>
                    <div id="fp-lga-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>

             <div id="npc-fp-facility" class="form-group  npc-hidden">
    			<label for="fp-facility" class="col-md-4 control-label">Facility</label>
    			<div class="col-md-6">
                    <select class="form-control" id="fp-facility-select" name="fp-facility">
                        <option value="">Select Facility</option>
                    </select>
                    <div id="fp-facility-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
             </div>
    	</form>
    	<!-- spinner -->
        <div id="fp-loading" class="npc-spinner-medium npc-hidden"></div>
    </div>
    <div id="fp-result" class="panel-footer npc-hidden">
        <p>The Postcode for <strong><span id="fp-result-facility"></span></strong> facility in <strong><span id="fp-result-lga"></span></strong> LGA is:</p>
        <h3 id="fp-result-postcode"></h3>
    </div>
</div>
