
    <div id="content">
        <div class="form">
            <form id="login-form" action="/index.php/receipt/create" method="post">

              <table>
                  <tr>
                      <td>进货编号：</td>
                      <td> <input name="receiptCode" readonly="true" type="text" /></td>
                  </tr>
                  <tr>
                      <td>厂商id：</td>
                      <td> <input name="companyId" type="text" /></td>
                  </tr>
                  <tr>
                      <td>进货金额：</td>
                      <td> <input name="purchaseAmount" type="text" /></td>
                  </tr>
                  <tr>
                      <td>进货日期：</td>
                      <td> <input name="receiptDate" type="text" /></td>
                  </tr>
                  <tr>
                      <td>备注：</td>
                      <td> <input name="remark" type="text" /></td>
                  </tr>
              </table>

                <div class="row buttons">
                    <input type="submit" name="yt0" value="提交" />	</div>
            </form></div><!-- form -->
    </div><!-- content -->

