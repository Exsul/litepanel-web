<?php
/*
* @LitePanel
* @Version: 1.0.1
* @Date: 29.12.2012
* @Developed by QuickDevel
*/
?>
<?php echo $header ?>
				<h2>Мои счета</h2>				
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>ID</th>
							<th>Статус</th>
							<th>Сумма</th>
							<th>Дата создания</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($invoices as $item): ?> 
						<tr>
							<td>#<?php echo $item['invoice_id'] ?></td>
							<td>
							<?php if($item['invoice_status'] == 0): ?> 
								<span class="label label-important">Не оплачен</span>
							<?php elseif($item['invoice_status'] == 1): ?> 
								<span class="label label-success">Оплачен</span>
							<?php endif; ?> 
							</td>
							<td><?php echo $item['invoice_ammount'] ?></td>
							<td><?php echo $item['invoice_date_add'] ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($invoices)): ?> 
						<tr>
							<td colspan="5" style="text-align: center;">На данный момент у Вас нет счетов.</td>
						<tr>
						<?php endif; ?> 
					</tbody>
				</table>
				<?php echo $pagination ?> 
<?php echo $footer ?>
