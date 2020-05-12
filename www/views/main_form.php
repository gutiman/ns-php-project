<div class="cell">
    <div class="grid-x">
        <div class="cell small-8 small-offset-2 top-space">
            <form id="form_lookup">
                <input type="hidden" name="model" value="lookup" />
                <input type="hidden" name="function" value="lookupForDNS" />
                <fieldset>
                    <legend>Lookup DNS</legend>
                    <div class="grid-container">
                        <div class="grid-x grid-padding-x">
                            <div class="cell small-10">
                                <label>Please enter de web page / domain / DNS to lookup:
                                    <input type="text" placeholder="Click here" id="lookup_first" />
                                </label>
                            </div>
                            <div class="cell small-2 top-space">
                                <button type="button" class="button primary" id="btn_add_list">Add to list</button>
                            </div>
                        </div>

                        <div class="grid-x grid-padding-x">
                            <div class="cell small-12" id="div_dns_to_lookup"></div>
                        </div>

                        <div class="grid-x grid-padding-x">
                            <div class="cell text-center">
                                <button type="button" class="button success hidden" id="btn_do_lookup">Lookup!</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <div class="grid-x">
        <div class="cell small-10 small-offset-1 top-space" id="div_last_10_domains"></div>
    </div>
</div>

<script src="./scripts/js/lookup/lookup.js"></script>