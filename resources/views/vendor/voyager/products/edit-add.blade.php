@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')


<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item active">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Product</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Dates Inventary</a>
  </li>
 
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade active in" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-9"> 
                                    @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Adding / Editing -->
                                @php
                                    $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                @endphp
                                
                                
                                <?php $hiddenRows=array("image","product_belongsto_city_relationship","latitude","longitude","product_belongsto_type_relationship","product_belongsto_coupon_relationship","service_free") ?>
                                <?php $hiddenFields=array("location","product_belongsto_city_relationship","product_belongsto_organizator_relationship") ?>
                                @foreach($dataTypeRows as $row)
                                    <!-- GET THE DISPLAY OPTIONS -->
                                    @php
                                        $options = ($row->details);
                                        $display_options = isset($options->display) ? $options->display : NULL;
                                    @endphp
                                    @if ($options && isset($options->formfields_custom))
                                        @include('voyager::formfields.custom.' . $options->formfields_custom)
                                    @else
                                        @if(!in_array($row->field,$hiddenRows))
                                            @if(!in_array($row->field,$hiddenFields))                                        
                                        <div class="form-group {{$row->field}} @if($row->type == 'hidden') hidden @endif @if(isset($display_options->width)){{ 'col-md-' . $display_options->width }}@else{{ 'col-md-12' }}@endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}

                        
                                            @if($row->field == "prices")
                                            
                                             
                                            <div class="prices-container well" style="display:none">
                                                
                                            </div>
                                         
                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-primary" onclick="addPrice()" type="button">Add price</button>
                                                </div>
                                            </div>
                                            <input type="hidden" value="[]" name="prices" id="pricesjson"/>
                                            
                                            @else
                                            @if($row->field == "images")
                                            <hr/>
                                            @endif

                                            <label for="name">{{ $row->display_name }} {{ $row->slug }}</label>
                                                @include('voyager::multilingual.input-hidden-bread-edit-add')
                                                @if($row->type == 'relationship')
                                                    @include('voyager::formfields.relationship')
                                                @else
                                                    {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                                @endif

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach

                                             @if($row->field == "images")
                                            <hr/>
                                            @endif
                                            @endif
                                            
                                        </div>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                              
                                <div class=" col-lg-12">
                                    
                                    <input type="hidden" name="location[lat]" value="-33.4718999" id="lat">
                                    <input type="hidden" name="location[lng]" value="-70.9100237" id="lng">
                                                                    <input id="pac-input" class="form-control" type="text" placeholder="Búscar lugar">
<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>

<script type="application/javascript">
    
    function initMap() {
        @forelse($dataTypeContent->getCoordinates() as $point)
            var center = {lat: {{ $point['lat'] }}, lng: {{ $point['lng'] }}};
        @empty
            var center = {lat: {{ config('voyager.googlemaps.center.lat') }}, lng: {{ config('voyager.googlemaps.center.lng') }}};
        @endforelse
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: {{ config('voyager.googlemaps.zoom') }},
            center: center
        });
        var markers = [];
        
        
         var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        
         searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

      

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
         
         
         
         
           var marker = new google.maps.Marker({
                    position: places[0].geometry.location,
                    map: map,
                    animation: google.maps.Animation.DROP,
                    draggable:true,

                });
            markers.push(marker);
         
            map.setCenter(new google.maps.LatLng(places[0].geometry.location.lat(), places[0].geometry.location.lng()));
              
                 
         google.maps.event.addListener(marker, 'dragend', function(marker){
        var latLng = marker.latLng; 
 
          
            document.getElementById('lat').value = latLng.lat();
            document.getElementById('lng').value =latLng.lng();
     });
              
            document.getElementById('lat').value = places[0].geometry.location.lat();
            document.getElementById('lng').value = places[0].geometry.location.lng();

        });
        
    
        
        @foreach($dataTypeContent->getCoordinates() as $point)
            var marker = new google.maps.Marker({
                    position: {lat: {{ $point['lat'] }}, lng: {{ $point['lng'] }}},
                    map: map,
                        animation: google.maps.Animation.DROP,
                                draggable:true,

                });
            markers.push(marker);
            
         google.maps.event.addListener(marker, 'dragend', function(marker){
        var latLng = marker.latLng; 
 
        document.getElementById('lat').value = latLng.lat();
            document.getElementById('lng').value =latLng.lng();
     });
               
            document.getElementById('lat').value = {{$point['lat']}};
document.getElementById('lng').value = {{$point['lng']}};
        @endforeach
    }
</script>

<div id="map"></div> 

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsim5uUfXaXzRrlO1xqNl9Mo14Fq-OZhU&libraries=places&callback=initMap"
         async defer></script>  
                                </div>
                                
                                   <!-- end form-group -->
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="">
                                        
                                         
                                        
                                         @foreach($dataTypeRows as $row)
                                    <!-- GET THE DISPLAY OPTIONS -->
                                    @php
                                        $options = ($row->details);
                                        $display_options = isset($options->display) ? $options->display : NULL;
                                    @endphp
                                    @if ($options && isset($options->formfields_custom))
                                        @include('voyager::formfields.custom.' . $options->formfields_custom)
                                    @else
                                    
                                        @if(in_array($row->field,$hiddenRows))
                                            @if(!in_array($row->field,$hiddenFields))                                        

                                        
                                        <div class="form-group @if($row->type == 'hidden') hidden @endif @if(isset($display_options->width)){{ 'col-md-' . $display_options->width }}@else{{ '' }}@endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                            {{ $row->slugify }}                                            
                                                <label for="name">{{ $row->display_name }} {{ $row->slug }}</label>
                                                @include('voyager::multilingual.input-hidden-bread-edit-add')
                                                @if($row->type == 'relationship')
                                                    @include('voyager::formfields.relationship')
                                                @else
                                                    {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                                @endif
                                            

                                            @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                            @endforeach
                                        </div>
                                        @endif
                                        @endif

                                    @endif
                                @endforeach
                                        
                                  <div class="form-group">
                                                <label>City</label>
                                                <select class="form-control" name="city_id">
                                                    @foreach ($allRegions as $region)
                                                        <option value="{{ $region->id }}" @if(isset($regionForProduct))  {{ $regionForProduct->contains($region) ? 'selected' : '' }} @endif>{{ $region->name }}</option>
                                                    @endforeach
                                                </select>
                                              
                                        </div>
                                
                                <div class="form-group">
                                                <label>Organizator</label>
                                                <select class="form-control" name="organizator_id">
                                                    <option value="0">Select Organizator</option>
                                                    @foreach ($organizatorByCountry as $organizator)
                                                        <option value="{{ $organizator->id }}" @if(isset($organizatorsForProduct))  {{ $organizatorsForProduct->contains($organizator) ? 'selected' : '' }} @endif>{{ $organizator->name }}</option>
                                                    @endforeach
                                                </select>
                                              
                                        </div>
                                
                                
                                
                                       <div class="form-group">
                                                <label>Categories</label>

                                                <ul style="list-style-type: none; padding-left: 0">
                                                @foreach ($allCategories as $category)
                                                    <li><label><input value="{{ $category->id }}" type="checkbox" name="category[]" style="margin-right: 5px;" {{ $categoriesForProduct->contains($category) ? 'checked' : '' }}>{{ $category->name }}</label></li>
                                                @endforeach
                                                </ul>
                                        </div>
                                
                                      
                                    </div>
                                </div>
                            </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">{{ __('voyager.generic.save') }}</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>

  </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        
       <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    
                    <form onsubmit="return submitForm()">
                        <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden"  id="idProduct" value="{{$dataTypeContent->id}}"/>
                                <div class="form-group col-md-4">
                                    <label>Date</label>
                                    <input class="form-control" id="dateProduct" type="date" required="required"/>
                                </div>
                                 <div class="form-group col-md-4">
                                    <label>Type</label>
                                    <select class="form-control" id="typeProduct">
                                        <option value="0">Select One</option>
                                        @foreach($dataTypeContent->pricesProduct as $priceProduct)
                                        <option value="{{$priceProduct->id}}">{{$priceProduct->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <br/>
                                    <button class="btn btn-primary">Search</button>
                                </div>
                                
                                
                            </div>
                            
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped" >
                                    <thead>
                                        <tr><th>Nombre</th><th>Cantidad</th><th>Fecha</th><th></th></tr>
                                    </thead>
                                    <tbody id="table-dates-inventary">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</div>


    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager.generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager.generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager.generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager.generic.delete_confirm') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>
        var params = {}
        var $image
        
         function updateInventary(index){
            
             $.post('{{ route('updateInventary') }}', {idProduct:$("#idProduct").val(),price_product_id:$("#priceValueId_"+index).val(),quantity:$("#quantityPrice_"+index).val(),date:$("#dateProduct").val()}, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                               
                       
                    } else {
                        toastr.error(response.data.error);
                    }
                });
            
            return false;
        }
        
        function submitForm(){
            
             $.post('{{ route('checkInventary') }}', {idProduct:$("#idProduct").val(),dateProduct:$("#dateProduct").val(),typeProduct:$("#typeProduct").val()}, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                                var data=response.data.data;
                                var htmlInner="";
                                for(var i =0; i<data.length;i++){
                                    console.log(data[i]);
                                    htmlInner+='<tr><td>'+data[i].name+'</td><td><input type="hidden" id="priceValueId_'+i+'" value="'+data[i].id+'"/><input id="quantityPrice_'+i+'" class="form-control" value="'+data[i].quantity+'" type="text"/></td><td>'+data[i].date+'</td><td><button type="button" onclick="updateInventary('+i+')" class="btn btn-primary">Update</button></td></tr>';
                                }
                        $("#table-dates-inventary").html(htmlInner);
                       
                    } else {
                        toastr.error(response.data.error);
                    }
                });
            
            return false;
        }
        
        
        var pricesJson=JSON.parse('{!! $dataTypeContent->pricesProduct !!}');
        
        $("#pricesjson").val(JSON.stringify(pricesJson));
  $(".quantity input").val(0);
  
 $(".quantity").hide();
        function renderPrices(){
            
            if(pricesJson.length>0){
                $(".prices-container").show();
            }
             $(".prices-container").html("");
            for(var i =0 ; i<pricesJson.length;i++){
                
                var pricesTemplate='';
                    pricesTemplate+='<div class="row element_'+i+'">';
                        pricesTemplate+='<div class="col-md-4">';
                            pricesTemplate+='<div class="form-group">';
                                pricesTemplate+='<label>Name</label>';
                                pricesTemplate+='<input type="text"    onkeyup="updateValue('+i+',this.value,\'name\')" value="'+pricesJson[i].name+'" class="form-control"/>';
                            pricesTemplate+='</div>';
                        pricesTemplate+='</div> ';
                        pricesTemplate+='<div class="col-md-3">';
                            pricesTemplate+='<div class="form-group">';
                                pricesTemplate+='<label>Quantity</label>';
                                pricesTemplate+='<input type="number"   onkeyup="updateValue('+i+',this.value,\'quantity\')" onkeyup value="'+pricesJson[i].quantity+'" class="form-control"/>';
                            pricesTemplate+='</div>';
                        pricesTemplate+='</div>';
                        
                        pricesTemplate+='<div class="col-md-3">';
                            pricesTemplate+='<div class="form-group">';
                                pricesTemplate+='<label>Value</label>';
                                pricesTemplate+='<input type="number"   onkeyup="updateValue('+i+',this.value,\'value\')" onkeyup value="'+pricesJson[i].value+'" class="form-control"/>';
                            pricesTemplate+='</div>';
                        pricesTemplate+='</div>';
                        
                        if(i>0){
                            
                        pricesTemplate+='<div class="col-md-2">';
                            pricesTemplate+='<div class="form-group">';
                                pricesTemplate+='<br/>';
                                pricesTemplate+='<button class="btn btn-danger" onclick="deleteRow('+i+')">x</button>';
                            pricesTemplate+='</div>';
                        pricesTemplate+='</div>';
                    }
                    pricesTemplate+='</div>';
                    
                    $(".prices-container").append(pricesTemplate);
            }
        }

function updateValue(index,value,field){
pricesJson[index][field]=value;
$("#pricesjson").val(JSON.stringify(pricesJson));



  if(pricesJson.length==0){
                $(".price input").val(0);
    }else{
        $(".price input").val(pricesJson[0].value);
    }

}


function deleteRow(i){
    
     if(pricesJson.length>0){
        $(".prices-container").show();
            }else{
        $(".prices-container").hide();
    
        }
    pricesJson.splice(i, 1);
    $("#pricesjson").val(JSON.stringify(pricesJson));

    renderPrices();
    console.log(pricesJson);
}

        function addPrice(){
            pricesJson.push({"name":"","value":""});
            renderPrices();
        }
        $('document').ready(function () {
        
            $(".price").hide();
            
            
            if(pricesJson.length==0){
                
                pricesJson.push({"name":"normal","value": $(".price input").val()});
                
            }else{
//                pricesJson.push({"name":"normal","value":""});
                $(".price input").val(pricesJson[0].value);
            }
            
            renderPrices();
            
            
            
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', function (e) {
                $image = $(this).siblings('img');

                params = {
                    slug:   '{{ $dataType->slug }}',
                    image:  $image.data('image'),
                    id:     $image.data('id'),
                    field:  $image.parent().data('field-name'),
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text($image.data('image'));
                $('#confirm_delete_modal').modal('show');
            });

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $image.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing image.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();

            var price = $('input[name="price"').val();
            $('input[name="price"').val(price);
        });
        
        
        
       
    </script>
@stop
