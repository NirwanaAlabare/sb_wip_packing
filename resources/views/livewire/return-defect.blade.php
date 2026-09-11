<div>
    <div class="loading-container-fullscreen" wire:loading wire:target="selectDefectAreaPosition, preSubmitInput, submitInput, updateOrder">
        <div class="loading-container">
            <div class="loading"></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card h-100">

            <div class="card-header d-flex justify-content-between align-items-center bg-defect text-light">
                <p class="mb-0 fs-5">WAITING LIST</p>

                <span class="badge bg-light text-dark fs-6">
                    {{ $summary->total() }}
                </span>
            </div>

            <div class="card-body">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>PO</th>
                            <th>Line</th>
                            <th>Masterplan</th>
                            <th>Size</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($summary->count() < 1)
                            <tr>
                                <td colspan='5'>Waiting tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($summary as $row)
                                <tr>
                                    <td>{{ $row->updated_at }}</td>
                                    <td>{{ $row->po }}</td>
                                    <td>{{ $row->line_qc_finishing }}</td>
                                    <td>{{ $row->masterplan }}</td>
                                    <td>{{ $row->size }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm bg-sb-secondary text-light"
                                            wire:click="openDefectModal({{ $row->id }}, {{ $row->master_plan_id }}, {{ $row->so_det_id }})">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $summary->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card h-100">

            <div class="card-header d-flex justify-content-between align-items-center bg-defect text-light">
                <p class="mb-0 fs-5">DEFECT LIST</p>

                <span class="badge bg-light text-dark fs-6">
                    {{ $summaryDefect->total() }}
                </span>
            </div>

            <div class="card-body">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>PO</th>
                            <th>Line</th>
                            <th>Masterplan</th>
                            <th>Size</th>
                            <th>Defect Type</th>
                            <th>Defect Area</th>
                            <th>Gambar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($summaryDefect->count() < 1)
                            <tr>
                                <td colspan='9'>Defect tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($summaryDefect as $row)
                                <tr>
                                    <td>{{ $row->updated_at }}</td>
                                    <td>{{ $row->po }}</td>
                                    <td>{{ $row->line_qc_finishing }}</td>
                                    <td>{{ $row->masterplan }}</td>
                                    <td>{{ $row->size }}</td>
                                    <td>{{ $row->defect_type }}</td>
                                    <td>{{ $row->defect_area }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-dark"
                                            wire:click="showDefectAreaImage('{{ $row->gambar }}', {{ $row->defect_area_x }}, {{ $row->defect_area_y }})">
                                            <i class="fa-regular fa-image"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $summaryDefect->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Defect Modal --}}
    <div class="modal" tabindex="-1" id="defect-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-defect text-light">
                    <h5 class="modal-title">DEFECT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            @error('defectType')
                                <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                                    <small>
                                        <strong>Error</strong> {{$message}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </small>
                                </div>
                            @enderror
                            <div class="d-flex align-items-center mb-1">
                                <button type="button" class="btn btn-sm btn-light rounded-0 me-1" wire:click="$emit('showModal', 'addDefectType')">
                                    <i class="fa-regular fa-plus fa-xs"></i>
                                </button>
                                <label class="form-label me-1 mb-0">Defect Type</label>
                            </div>
                            <div wire:ignore id="select-defect-type-container">
                                <select class="form-select @error('defectType') is-invalid @enderror" id="defect-type-select2" wire:model='defectType'>
                                    <option value="" selected>Select defect type</option>
                                    @foreach ($defectTypes as $defect)
                                        <option value="{{ $defect->id }}">
                                            {{ $defect->defect_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            @error('defectArea')
                                <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                                    <small>
                                        <strong>Error</strong> {{$message}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </small>
                                </div>
                            @enderror
                            <div class="d-flex align-items-center mb-1">
                                <button type="button" class="btn btn-sm btn-light rounded-0 me-1" wire:click="$emit('showModal', 'addDefectArea')">
                                    <i class="fa-regular fa-plus fa-xs"></i>
                                </button>
                                <label class="form-label me-1 mb-0">Defect Area</label>
                            </div>
                            <div class="d-flex gap-1">
                                <div class="w-75" wire:ignore id="select-defect-area-container">
                                    <select class="form-select @error('defectArea') is-invalid @enderror" id="defect-area-select2" wire:model='defectArea'>
                                        <option value="" selected>Select defect area</option>
                                        @foreach ($defectAreas as $defect)
                                            <option value="{{ $defect->id }}">
                                                {{ $defect->defect_area }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-25">
                                    <button type="button" wire:click="selectDefectAreaPosition" class="btn btn-dark w-100">
                                        <i class="fa-regular fa-image"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            @if ($errors->has('defectAreaPositionX') || $errors->has('defectAreaPositionY'))
                                <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                                    <small>
                                        <strong>Error</strong> Harap tentukan posisi defect area dengan mengklik tombol <button type="button"class="btn btn-dark btn-sm"><i class="fa-regular fa-image fa-2xs"></i></button> di samping 'select defect area'.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </small>
                                </div>
                            @endif
                            <div class="d-none">
                                <label class="form-label me-1 mb-2">Defect Area Position</label>
                                <div class="row">
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <label class="form-label me-1 mb-0">X </label>
                                        <div class="d-flex">
                                            <input class="form-control @error('defectAreaPositionX') is-invalid @enderror" id="defect-area-position-x-livewire" wire:model='defectAreaPositionX' readonly>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <label class="form-label me-1 mb-1">Y </label>
                                        <div class="d-flex">
                                            <input class="form-control @error('defectAreaPositionY') is-invalid @enderror" id="defect-area-position-x-livewire" wire:model='defectAreaPositionY' readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-sb-secondary" wire:click='submitInput'>Selesai</button>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ url('/') }}" class="back bg-sb-secondary text-light text-center w-auto">
    <i class="fa-regular fa-reply"></i>
</a>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Product Type

            Livewire.on('showModal', function (modal) {
                $('#' + modal + '-modal').modal('show');
            });

            Livewire.on('hideModal', function (modal) {
                $('#' + modal + '-modal').modal('hide');
            });

            $('#product-type-select2').select2({
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                dropdownParent: $('#defect-modal .modal-content #select-product-type-container')
            });

            $('#product-type-select2').on('change', function (e) {
                var productType = $('#product-type-select2').select2("val");
                @this.set('productType', productType);
            });

            // Defect Type
            $('#defect-type-select2').select2({
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                dropdownParent: $('#defect-modal .modal-content #select-defect-type-container')
            });

            $('#defect-type-select2').on('change', function (e) {
                var defectType = $('#defect-type-select2').select2("val");
                @this.set('defectType', defectType);
            });

            // Defect Area
            $('#defect-area-select2').select2({
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                dropdownParent: $('#defect-modal .modal-content #select-defect-area-container')
            });

            $('#defect-area-select2').on('change', function (e) {
                var defectArea = $('#defect-area-select2').select2("val");
                @this.set('defectArea', defectArea);
            });

            Livewire.on('clearSelectDefectAreaPoint', () => {
                $('#product-type-select2').val("").trigger('change');
                $('#defect-type-select2').val("").trigger('change');
                $('#defect-area-select2').val("").trigger('change');
            });
        })
    </script>
@endpush
