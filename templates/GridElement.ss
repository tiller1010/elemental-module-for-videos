<div class="grid-element desktop-width-$DesktopWidth phone-width-$PhoneWidth">
	<% if $GridSections %>
	    <% loop $GridSections %>
		    <div class="grid-section-container desktop-width-$DesktopWidth phone-width-$PhoneWidth">
		    	<div class="grid-section-space">
		    		$Content
		    	</div>
		    </div>
	    <% end_loop %>
	<% end_if %>
</div>