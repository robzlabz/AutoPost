<style>.box { background: #fff; padding: 10px ; border-radius: 0px 0px 3px 3px;} .wrap > h1 {background: #00c0ef; border-radius: 3px 3px 0px 0px ; padding: 5px}</style>
<?php if (($gt = get_option('agcm_token')) == '') { update_option('agcm_token', gt());} ?>
<?php if(isset($_POST['gtoken'])) : update_option('agcm_token', gt()) ?>
    <div class="notice updated"><p><strong>Yuhu! </strong> your token successfully regenerated</p></div>
<?php endif; ?>
<div class="wrap">
    <h1>AGC Manager Connector</h1>
    <div class="box">
        <form action="" method="POST" id="form">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label>Your Domain</label></th>
                        <td>
                            <?php echo $_SERVER['HTTP_HOST']; ?>    
                        </td>
                    </tr>
                    <tr>
                        <th><label>Token</label></th>
                        <td>
                        <input type="text" onclick="this.setSelectionRange(0, this.value.length)" value="<?php echo get_option('agcm_token') ?>" class="regular-text" readonly="true"/>
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