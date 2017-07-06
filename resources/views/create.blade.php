@extends('layouts.app')

@section('content')
                <!-- form-container -->
                <section class="form-container">
				<form action="/upload" method="post" enctype="multipart/form-data">
					{!! csrf_field() !!}
                    <div class="col-sm-7 col-xs-12 bg-blue text-center">
                        <input type="file" class="upload" name="video" accept='video/*'>
                    </div>

                    <div class="col-xs-12 col-sm-3 form">
                        <div class="form-group">
                        	<p><input type="text" name="title" id="title" class="form-control" placeholder="Title" /></p>
                            <p><textarea name="description" id="description" class="form-control" placeholder="Description"></textarea></p>
                            <p><input type="date" name="expiration" id="expiration" class="form-control" placeholder="Expiration date" /></p>
                            <p><input type="text" name="what" id="what" class="form-control" placeholder="#What" /></p>
                            <p><input type="text" name="where" id="where" class="form-control" placeholder="#Where" /></p>
                            <p><input type="text" name="who" id="who" class="form-control" placeholder="#Who" /></p>
                            <p><input type="text" name="when" id="when" class="form-control" placeholder="#When" /></p>
                            <input type="submit" class="btn bg-blue btn-submit col-xs-12 col-sm-8" value="submit"/>
                        </div>
                    </div>
                  </form> 
                </section><!-- form-container -->
	

                <!-- /modules -->
@endsection