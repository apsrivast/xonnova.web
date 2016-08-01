<div ng-include="'application/views/admin/views/templates/custom-styles.html'"></div>

<ng-include src="'application/views/admin/views/layout/header.html'"></ng-include>

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
					<li id="asideuser" class="text-center" style=" display: none;" ng-repeat="data in list">
		  				<a href="#/profile"> <img class="img-circle" alt="" src="./uploads/{{data.image}}" style="height: 80px; width: 80px; border: 1px solid rgb(0, 0, 0); margin: 10px 0px;"> <br><asd style="color: #C4D0D9; ">{{data.user_name }} </asd></a>
					</li>
			  	  <li id="search" ng-cloak>
	                
					<form
					ng-click="$event.stopPropagation()"
					ng-submit="goToSearch()">
						<input type="text" ng-model="searchQuery" class="search-query" placeholder="Search" style="padding-left: 10px; background-color: #1C2B36;  min-height: 40px;"/>
						<button type="submit" ng-click="goToSearch()" style="left: 150px;"><i class="fa fa-search"></i></button>
					</form>
					<a href="">
	                	<i class="fa fa-binoculars opacity-control"></i>
	                </a>
	              </li>
	              <hr style="border-color: rgb(0, 0, 0); margin: 0px 10px;">
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
						<li>Xonnova &copy; 2016</li>
					</ul>
					<button class="pull-right btn btn-default btn-sm hidden-print" back-to-top style="padding: 1px 10px;"><i class="fa fa-angle-up"></i></button>
				</div>
			</footer>
		</div>
	</div>
</div>

<!-- <div ng-include="'/Onlegacy/application/views/admin/views/layout/infobar.html'" class="infobar-wrapper"></div> -->