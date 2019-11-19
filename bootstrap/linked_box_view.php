<?php  if(!empty($boxData)) : ?>
<div>
	<span class="m-right-10"><i>No of Pkts:</i> <?php echo $boxData['number_of_pkts']; ?></span>
	<span class="m-right-10"><i>Packet Size:</i> <?php echo $boxData['pkt_size']; ?></span>
	<span class="m-right-10"><i>Packet WT:</i> <?php echo $boxData['pkt_wt']; ?></span>
	<span class="m-right-10"><i>Box WT:</i> <?php echo $boxData['box_wt']; ?></span>
	<span class="m-right-10"><i>Total Packet WT:</i> <?php echo $boxData['total_pkt_wt']; ?></span>
</div>
<div>
	<span class="m-right-10"><i>Box Qty.:</i> <?php echo $boxData['box_qty']; ?></span>
	<span class="m-right-10"><i>Box Used Qty.:</i> <?php echo $boxData['tot_used_qty']; ?></span>
	<span class="m-right-10"><i>Box Unused Qty.:</i> <?php echo $boxData['box_qty']-$boxData['tot_used_qty']; ?></span>
</div>
<?php endif; ?>