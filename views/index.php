<style>
    .wrap h1 {background: #3c8dbc; border-radius: 3px 3px 0px 0px ; color: #fff; padding: 0 12px; line-height: 46px;}
    .agc, .update {border-radius: 3px;-moz-box-shadow:0 0 1px rgba(0,0,0,.8);-webkit-box-shadow:0 0 1px rgba(0,0,0,.8);box-shadow:0 0 1px rgba(0,0,0,.8);}
    .box {background: #fff; padding: 10px ; border-radius: 0px 0px 3px 3px;}
    .update {border-left: 4px solid #46b450; background: #fff; padding: 1px 6px 1px 12px;margin-bottom:10px;}
</style>
<?php if (($gt = get_option('agcm_token')) == '') { update_option('agcm_token', gt());} ?>
<div class="wrap">
    <?php if(isset($_POST['gtoken'])) : update_option('agcm_token', gt()) ?>
    <div class="update"><p><strong>Yaay!</strong> your token successfully regenerated</p></div>
    <?php endif; ?>
    <div class="agc">
        <h1>AGC Manager Connector</h1>
        <div class="box">
            <form action="" method="POST" id="form">
                <table style="margin-top:0;" class="form-table">
                   <tbody>
                        <tr>
                            <th>
                                <label>Your Domain</label>
                            </th>
                            <td>
                                <?php echo $_SERVER['HTTP_HOST']; ?>    
                            </td>
                         </tr>
                        <tr>
                            <th>
                                <label>Token</label>
                            </th>
                            <td>
                                <input style="width: 21em; text-align: center;" type="text" onclick="this.setSelectionRange(0, this.value.length)" value="<?php echo get_option('agcm_token') ?>" class="regular-text" readonly="true"/>
                                <p class="description">Copy this token to agcmanager.com</p>
                            </td>
                        </tr>
                    </tbody>
                </table>        
                <div class="nav-panel">
                    <button class="button-primary" name="gtoken" value="true" type="submit">Generate New Token</button>
                </div>
            </form>
        </div>
    </div>
</div>