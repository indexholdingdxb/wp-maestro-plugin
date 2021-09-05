<?php 
    $getRecordDetails = $db->showSingleRecord();
?>
<div class="wrap">
    <h1 id="add-new-user"> Add New App</h1>
    <div id="ajax-response"></div>
    <!-- <p>Connect a new app using API credentials.</p> -->
    <div class="row">
        <div style="width:50%; float:left">
            <form method="post" name="createuser" id="createuser" class="validate" novalidate="novalidate">
                <table class="form-table">
                    <tbody>
                        <!-- <tr class="form-field form-required">
                            <th scope="row"><label for="app_name">Name <span class="description">(required)</span></label>
                            </th>
                            <td><input name="app_name" require type="text" id="app_name" value="" aria-required="true" autocapitalize="none" autocorrect="off" maxlength="60"></td>
                        </tr> -->
                        <tr class="form-field form-required">
                            <th scope="row"><label for="url">URL <span class="description">(required)</span></label>
                            </th>
                            <td><input name="url" require type="text" id="url" value="<?php if(isset($getRecordDetails->url)){echo $getRecordDetails->url; } ?>" aria-required="true" autocapitalize="none" autocorrect="off"></td>
                        </tr>
                        <tr class="form-field form-required">
                            <th scope="row"><label for="access_key">Access Key <span class="description">(required)</span></label></th>
                            <td><input name="access_key" require type="password" id="access_key" value="<?php if(isset($getRecordDetails->access_key)){echo $getRecordDetails->access_key; } ?>"></td>
                        </tr>
                        <tr class="form-field">
                            <th scope="row"><label for="hash_key">Hash Key  <span class="description">(required)</span></label></th>
                            <td><input name="hash_key" require type="password" id="hash_key" value="<?php if(isset($getRecordDetails->hash_key)){echo $getRecordDetails->hash_key; } ?>"></td>
                        </tr>
                        <tr class="form-field">
                            <th scope="row"><label for="event_id">Event Id  <span class="description">(required)</span></label></th>
                            <td><input name="event_id" require type="text" id="event_id" value="<?php if(isset($getRecordDetails->event_id)){echo $getRecordDetails->event_id; } ?>"></td>
                        </tr>
                        <tr class="form-field">
                            <th scope="row"><label for="edition_id">Edition Id <span class="description">(required)</span></label></th>
                            <td><input name="edition_id" require type="text" id="edition_id" class="code" value="<?php if(isset($getRecordDetails->edition_id)){echo $getRecordDetails->edition_id; } ?>"></td>
                        </tr>
                        <tr class="form-field">
                            <th scope="row"><label for="app_edition_id">App Edition Id <span class="description">(required)</span></label></th>
                            <td><input name="app_edition_id" require type="text" id="app_edition_id" class="code" value="<?php if(isset($getRecordDetails->app_edition_id)){echo $getRecordDetails->app_edition_id; } ?>"></td>
                        </tr>
                        <tr class="form-field">
                            <th scope="row"><label for="token">Token</label></th>
                            <td><textarea name="token" id="token" cols="10" rows="10" readonly style="width:350px;"><?php if(isset($getRecordDetails->token)){echo $getRecordDetails->token; } ?></textarea></td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit"><input type="submit" name="create_maestro_api" id="create_maestro_api _setting" class="button button-primary" value="Update Setting"></p>
            </form>
        </div>
         <div style="width:50%; float:left">
            <code>Speaker: [speakers]</code><br /><br />
            <code>Speaker Featured and Limit: [speakers featured="x" limit="x"]</code><br /><br />
            <code>Specific Item Speaker: [speakers item_id="x"]</code><br /><br />
            <code>Item Location Speaker: [speakers item_id="x" session_location_id="x"]</code><br /><br />
            <code>Item Role Base Speaker: [speakers item_id="x" role_id="x"]</code><br /><br />
            <code>All Item Sessions: [agenda]</code><br /><br />
            <code>All Item Sessions Featured: [agenda featured=1]</code><br /><br />
            <code>Specific Item agenda: [agenda item_id="x"]</code><br /><br />
            <code>Session Location: [agenda session_location_id="x"]</code><br /><br />
            <code>Day Wise Data: [agenda date_from="YYYY-MM-DD"  date_to="YYYY-MM-DD"]</code><br /><br />
            <code>Session Speakers: [agenda item_id="x" show_session_speakers="yes"]</code><br /><br />
            <code>Custom: [agenda item_id="x" session_location_id="x" date_from="YYYY-MM-DD"  date_to="YYYY-MM-DD"]</code><br /><br />
            <code>Exhibitors: [exhibitors]</code><br /><br />
            <code>Exhibitors or Brands: [exhibitors brands=1]</code><br /><br />
            <code>Exhibitors Featured and Limit: [exhibitors featured="x" limit="x"]</code><br /><br />
            <code>Abstracts: [abstracts]</code><br /><br />
            <code>Abstracts with type filter: [abstracts item_id="x"]</code><br /><br />
            <code>Exhibitors Products: [products featured="x" limit="x"]</code><br />
        </div>
    </div>
    
</div>