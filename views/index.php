<style>.box { background: #fff; padding: 10px ; border-radius: 3px; }</style>
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
                            <?php echo get_option('agcm_token') ?>
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