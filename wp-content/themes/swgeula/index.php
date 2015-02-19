<?php get_header(); ?>	
<div class="row">
        <div class="col-md-9">					
				<div>
					<input type="text" ng-model="name">
			 
					<p>Hello, {{name}}!</p>
				</div>

				<div ng-view></div>
				</div>
				<div class="col-md-3">	
				<div class="sidebar">
				<div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
				<?php get_sidebar(); ?>
			</div><!-- .sidebar -->			
			</div>
			</div>
			<footer class="footer">
				<?php get_footer(); ?>
				