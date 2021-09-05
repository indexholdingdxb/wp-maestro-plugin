<?php 
    // $getRecordDetails = $db->showSingleRecord();
?>
<div class="wrap">
    <h1 id="add-new-user"> Add New App</h1>
    <div id="ajax-response"></div>
    <!-- <p>Connect a new app using API credentials.</p> -->
    <div class="row">
        <div style="width:50%; float:left">
            <form method="post" name="createuser" id="createuser" class="validate">
                <table class="form-table">
                    <tbody>
                        <tr class="form-field form-required">
                            <th scope="row"><label for="url">Name <span class="description">(required)</span></label></th>
                            <td>
                            <select name="name" id="name">
                                <option value="">Select Role</option>
                                <?php
                                    foreach ($rolese as $row) {
                                        echo "<option value='".$row['id']."***".$row['name']."'>".$row['name']."</option>";
                                    }
                                ?>
                            </select></td>
                        </tr>
                        <tr class="form-field">
                            <th scope="row"><label for="order_number">Sort Order <span class="description">(required)</span></label></th>
                            <td><input name="order_number" require type="text" id="order_number" value=""></td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit"><input type="submit" name="create_speaker_role" id="create_speaker_role" class="button button-primary" value="Add Record"></p>
            </form>
            <?php echo $gridData; ?>
        </div>
    </div>
</div>