<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add Audio Call</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross','fs-1') !!}
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="kt_modal_add_user_form" class="form" action="#" wire:submit.prevent="submit" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" wire:model.defer="audiocall_id" name="audiocall_id" value="{{ $audiocall_id }}"/>
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                        <!--begin::Input group-->
                        {{-- <div class="fv-row mb-7"> --}}
                            <!--begin::Label-->
                            {{-- <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                            <!--end::Label-->
                            <!--begin::Image placeholder-->
                            <style>
                                .image-input-placeholder {
                                    background-image: url('{{ image('svg/files/blank-image.svg') }}');
                                }

                                [data-bs-theme="dark"] .image-input-placeholder {
                                    background-image: url('{{ image('svg/files/blank-image-dark.svg') }}');
                                }
                            </style>
                            <!--end::Image placeholder-->
                            <!--begin::Image input-->
                            <div class="image-input image-input-outline image-input-placeholder {{ $avatar || $saved_avatar ? '' : 'image-input-empty' }}" data-kt-image-input="true">
                                <!--begin::Preview existing avatar-->
                                @if($avatar)
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $avatar ? $avatar->temporaryUrl() : '' }});"></div>
                                @else
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ $saved_avatar }});"></div>
                                @endif
                                <!--end::Preview existing avatar-->
                                <!--begin::Label-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    {!! getIcon('pencil','fs-7') !!}
                                    <!--begin::Inputs-->
                                    <input type="file" wire:model="avatar" name="avatar" accept=".png, .jpg, .jpeg"/>
                                    <input type="hidden" name="avatar_remove"/>
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label--> --}}
                                <!--begin::Cancel-->
                                {{-- <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    {!! getIcon('cross','fs-2') !!}
                                </span>
                                <!--end::Cancel-->
                                <!--begin::Remove-->
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    {!! getIcon('cross','fs-2') !!}
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                            @error('avatar')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!--end::Input group--> --}}
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model.defer="name" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name"/>
                            <!--end::Input-->
                            @error('name')
                            <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group for audio file-->
                            <div class="mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Upload Audio File</label>
                                <!--end::Label-->
                                <!--begin::File input-->
                                <input type="file" wire:model="file" name="file" class="form-control form-control-solid mb-3 mb-lg-0" accept="audio/*"/>
                                @error('file')
                                <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!--end::Input group-->
                        <!--begin::Input group-->
                            <div class="mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Audio Call Language</label>
                                <!--end::Label-->
                                <!--begin::Dropdown-->
                                <select wire:model.defer="language" name="language" class="form-control form-control-solid mb-3 mb-lg-0">
                                    <option value="">Select Language</option>
                                    <option value="english">English</option>
                                    <option value="urdu">Urdu</option>
                                    <option value="french">French</option>
                                    <option value="hindi">Hindi</option>
                                </select>
                                <!--end::Dropdown-->
                                @error('language')
                                <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-7">
                            {{-- <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-5">Type</label>
                            <!--end::Label-->
                            @error('usertype')
                            <span class="text-danger">{{ $message }}</span> @enderror --}}
                         <!--begin::Usertypes-->
                         {{-- @foreach($usertypes as $usertype) --}}
                         <!--begin::Input row-->
                         <div class="d-flex fv-row">
                             <!--begin::Radio-->
                             <div class="form-check form-check-custom form-check-solid">
                                 <!--begin::Input-->
                                 {{-- <input class="form-check-input me-3" id="kt_modal_update_usertype_option_{{ $usertype['type'] }}" wire:model.defer="usertype" name="usertype" type="radio" value="{{ $usertype['type'] }}" checked="checked"/>
                                 <!--end::Input-->
                                 <!--begin::Label-->
                                 <label class="form-check-label" for="kt_modal_update_usertype_option_{{ $usertype['type'] }}">
                                     <div class="fw-bold text-gray-800">
                                         {{ ucwords($usertype['type']) }}
                                     </div>
                                     <div class="text-gray-600">
                                         {{ $usertype['description'] }}
                                     </div>
                                 </label> --}}
                                 <!--end::Label-->
                             </div>
                             <!--end::Radio-->
                         </div>
                         <!--end::Input row-->
                         {{-- @if(!$loop->last)
                             <div class='separator separator-dashed my-5'></div>
                         @endif
                     @endforeach --}}
                            
                            <!--end::Roles--> 
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close" wire:loading.attr="disabled">Discard</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label" wire:loading.remove>Submit</span>
                            <span class="indicator-progress" wire:loading wire:target="submit">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>