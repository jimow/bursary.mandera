@extends('layouts.admin')
@section('styles')
<style>
.modal-custom {
    max-width: 50%; /* or whatever size you prefer */
}
</style>
@endsection
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.student.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.students.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.id') }}
                        </th>
                        <td>
                            {{ $student->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.fullname') }}
                        </th>
                        <td>
                            {{ $student->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\Student::GENDER_SELECT[$student->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.date_of_birth') }}
                        </th>
                        <td>
                            {{ $student->date_of_birth }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.ward') }}
                        </th>
                        <td>
                            {{ $student->ward->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.nemis_number') }}
                        </th>
                        <td>
                            {{ $student->nemis_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.admission_number') }}
                        </th>
                        <td>
                            {{ $student->admission_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.on_scholarship') }}
                        </th>
                        <td>
                            {{ App\Models\Student::ON_SCHOLARSHIP_SELECT[$student->on_scholarship] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.scholarship_amount') }}
                        </th>
                        <td>
                            {{ $student->scholarship_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.scholarship_donor') }}
                        </th>
                        <td>
                            {{ $student->scholarship_donor }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.disability') }}
                        </th>
                        <td>
                            {{ App\Models\Student::DISABILITY_SELECT[$student->disability] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.parental_status') }}
                        </th>
                        <td>
                            {{ App\Models\Student::PARENTAL_STATUS_SELECT[$student->parental_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.father_fullname') }}
                        </th>
                        <td>
                            {{ $student->father_fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.father_phone_number') }}
                        </th>
                        <td>
                            {{ $student->father_phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.father_death_certificate') }}
                        </th>
                        <td>
                            @if($student->father_death_certificate)
                                <a href="{{ $student->father_death_certificate->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $student->father_death_certificate->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.mother_fullname') }}
                        </th>
                        <td>
                            {{ $student->mother_fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.mother_phone_number') }}
                        </th>
                        <td>
                            {{ $student->mother_phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.mother_death_certificate') }}
                        </th>
                        <td>
                            @if($student->mother_death_certificate)
                            <a href="javascript:void(0);" onclick="openImageInModal('{{ $student->mother_death_certificate->getUrl() }}')" style="display: inline-block">
                                <img src="{{ $student->mother_death_certificate->getUrl('thumb') }}">
                            </a>
                        @endif
                        
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.photo') }}
                        </th>
                        <td>
                            @if($student->photo)
                                <a href="{{ $student->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $student->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.stream') }}
                        </th>
                        <td>
                            {{ $student->stream->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.school') }}
                        </th>
                        <td>
                            {{ $student->school->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.form') }}
                        </th>
                        <td>
                            {{ $student->form->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.birth_certificate') }}
                        </th>
                        <td>
                            @if($student->birth_certificate)
                                <a href="{{ $student->birth_certificate->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.birth_certificate_number') }}
                        </th>
                        <td>
                            {{ $student->birth_certificate_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.father_national_id_no') }}
                        </th>
                        <td>
                            {{ $student->father_national_id_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.mother_national_id_no') }}
                        </th>
                        <td>
                            {{ $student->mother_national_id_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Student::STATUS_SELECT[$student->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.day_scholar') }}
                        </th>
                        <td>
                            {{ App\Models\Student::DAY_SCHOLAR_SELECT[$student->day_scholar] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.registered_by') }}
                        </th>
                        <td>
                            {{ $student->registered_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.approved_by') }}
                        </th>
                        <td>
                            {{ $student->approved_by->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.guardian_fullname') }}
                        </th>
                        <td>
                            {{ $student->guardian_fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.guardian_phone_number') }}
                        </th>
                        <td>
                            {{ $student->guardian_phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.guardian_national') }}
                        </th>
                        <td>
                            {{ $student->guardian_national }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.other_documents') }}
                        </th>
                        <td>
                            @foreach($student->other_documents as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.schooled_in_mandera') }}
                        </th>
                        <td>
                            {{ App\Models\Student::SCHOOLED_IN_MANDERA_SELECT[$student->schooled_in_mandera] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.primary_school') }}
                        </th>
                        <td>
                            {{ $student->primary_school }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.kcpe_certificate') }}
                        </th>
                        <td>
                            @if($student->kcpe_certificate)
                                <a href="{{ $student->kcpe_certificate->getUrl() }}" target="_blank">
                                    <img src="{{ $student->kcpe_certificate->getUrl('thumb') }}">
                    
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.kcpe_result_slip') }}
                        </th>
                        <td>
                            @if($student->kcpe_result_slip)
                                <a href="{{ $student->kcpe_result_slip->getUrl('thumb') }}" target="_blank">
                                    <img src="{{ $student->kcpe_result_slip->getUrl('thumb') }}">
                     {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.leaving_certificate') }}
                        </th>
                        <td>
                            @if($student->leaving_certificate)
                                <a href="{{ $student->leaving_certificate->getUrl('thumb') }}" target="_blank">
                                    <img src="{{ $student->leaving_certificate->getUrl('thumb') }}">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.student.fields.report_form') }}
                        </th>
                        <td>
                            @if($student->report_form)
                                <a href="{{ $student->report_form->getUrl('thumb') }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.students.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@if($student->father_death_certificate)
    <a href="#" onclick="showImageModal('{{ $student->father_death_certificate->getUrl() }}')" style="display: inline-block">
        <img src="{{ $student->father_death_certificate->getUrl('thumb') }}">
    </a>
@endif


<a href="#" onclick="showSlideshowModal(0);" style="display: inline-block">
    <img src="{{ $student->father_death_certificate->getUrl('thumb') }}" alt="Father Death Certificate">
</a>
<a href="#" onclick="showSlideshowModal(1);" style="display: inline-block">
    <img src="{{ $student->birth_certificate->getUrl('thumb') }}" alt="Birth Certificate">
</a>
<!-- Repeat for other images, increasing the index each time -->


<!-- Image Modal -->
<div class="modal fade modal-custom" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <iframe id="imageIframe" src="" frameborder="0" style="width:100%;min-height:600px;"></iframe>
        </div>
      </div>
    </div>
  </div>
  


  <!-- Slideshow Modal -->
<div class="modal fade" id="imageSlideshowModal" tabindex="-1" aria-labelledby="imageSlideshowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageSlideshowModalLabel">Image Slideshow</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Carousel -->
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              {{-- Carousel items will be inserted here dynamically --}}
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection

@section('scripts')

<script>

function openImageInModal(url) {
    // Set the iframe src to the URL of the image
    document.getElementById('imageIframe').src = url;
    // Use jQuery to open the modal
    $('#imageModal').modal('show');
}

   function showImageModal(imageUrl) {
    console.log(imageUrl); // Check if the URL is correctly received
    $('#modalImage').attr('src', imageUrl);
    $('#imageModal').modal('show');
}

    </script>


<script>
    // Array of image URLs
    var images = [
        "{{ $student->father_death_certificate->getUrl() }}",
        "{{ $student->birth_certificate->getUrl() }}",
        // Add more URLs as needed
    ];
    
    function showSlideshowModal(startIndex) {
        var carouselInner = $('#carouselExampleControls .carousel-inner');
        carouselInner.empty(); // Clear existing items
    
        images.forEach(function(url, index) {
            var itemClass = index === startIndex ? 'carousel-item active' : 'carousel-item';
            carouselInner.append(
                '<div class="' + itemClass + '">' +
                    '<img src="' + url + '" class="d-block w-100">' + // Adjust classes as needed
                '</div>'
            );
        });
    
        $('#imageSlideshowModal').modal('show'); // Show the modal
        $('#carouselExampleControls').carousel(startIndex); // Go to the clicked image
    }
    </script>
    
    
@endsection