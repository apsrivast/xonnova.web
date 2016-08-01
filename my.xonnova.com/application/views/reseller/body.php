<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5603de60648412897387d451/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<div ng-include="'application/views/templates/custom-styles.html'"></div>



<ng-include src="'application/views/layout/header.html'"></ng-include>



<nav id="headernav" class="navbar ng-hide" role="navigation" ng-show="getLayoutOption('layoutHorizontal') && !layoutLoading">

	<div class="nav">

		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">

			<i class="fa fa-reorder"></i>

		</button>

	</div>

	<div class="collapse navbar-collapse navbar-ex1-collapse" ng-class="{'large-icons-nav': getLayoutOption('layoutHorizontalLargeIcons')}" id="horizontal-navbar">

		  <ul ng-controller="NavigationController" id="top-nav" class="nav navbar-nav">

			  <li ng-repeat="item in menu"

				  ng-if="!item.hideOnHorizontal"

				  ng-class="{ hasChild: (item.children!==undefined),

								active: item.selected,

								  open: (item.children!==undefined) && item.open,

					   'nav-separator': item.separator==true }"

				  ng-include="'templates/nav_renderer_horizontal.html'"

				></li>

		  </ul>

	</div>

</nav>





<div id="wrapper">

	<div id="layout-static">

		<div class="static-sidebar-wrapper" ng-show="!layoutLoading">

			<nav class="static-sidebar" role="navigation">

				<ul ng-controller="NavigationController" id="sidebar" sticky-scroll="50">

			  	  <li id="search" ng-cloak>

	                <a href="">

	                	<i class="fa fa-binoculars opacity-control"></i>

	                </a>

					<form

					ng-click="$event.stopPropagation()"

					ng-submit="goToSearch()">

						<input type="text" ng-model="searchQuery" class="search-query" placeholder="Type to filter..." />

						<button type="submit" ng-click="goToSearch()"><i class="fa fa-binoculars"></i></button>

					</form>

	              </li>

				  <li ng-repeat="item in menu"

					  ng-class="{ hasChild: (item.children!==undefined),

									active: item.selected,

									  open: (item.children!==undefined) && item.open,

						   'nav-separator': item.separator==true,

	            			'search-focus': (searchQuery.length>0 && item.selected) }" 

	            		ng-show="!(searchQuery.length && !item.selected)"

					  ng-include="'templates/nav_renderer.html'"

					></li>

				</ul>

			</nav> <!-- #sidebar-->

		</div>

		<div class="static-content-wrapper">

			<div class="static-content">

				<div id="wrap" ng-view="" class="mainview-animation animated">

				</div> <!--wrap -->

			</div>

			<footer role="contentinfo" ng-show="!layoutLoading">

				<div class="clearfix">

					<ul class="list-unstyled list-inline pull-left">

						<li>Onlegacy Network &copy; 2015</li>

					</ul>

					<button class="pull-right btn btn-default btn-sm hidden-print" back-to-top style="padding: 1px 10px;"><i class="fa fa-angle-up"></i></button>

				</div>

			</footer>

		</div>

	</div>

</div>



<!-- <div ng-include="'application/views/admin/views/layout/infobar.html'" class="infobar-wrapper"></div> -->