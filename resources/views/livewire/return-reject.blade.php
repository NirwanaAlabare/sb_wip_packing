<div wire:init="loadRejectPage">
    <div class="loading-container-fullscreen" wire:loading wire:target="selectRejectAreaPosition, preSubmitInput, submitInput, updateOrder">
        <div class="loading-container">
            <div class="loading"></div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-reject text-light">
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
                            <th>Tombol</th>
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
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm bg-sb-secondary text-light"
                                            wire:click="openDefectModalReject({{ $row->rfts_return_id }}, {{ $row->id }}, {{ $row->master_plan_id }}, {{ $row->so_det_id }})">
                                            <i class="fas fa-times"></i>
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

    <div class="col-md-12 mt-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-reject text-light">
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
                                            wire:click="openDefectModal({{ $row->id }}, null, {{ $row->master_plan_id }}, {{ $row->so_det_id }})">
                                            <i class="fas fa-times"></i>
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
            <div class="card-header d-flex justify-content-between align-items-center bg-reject text-light">
                <p class="mb-0 fs-5">REJECT LIST</p>
                <span class="badge bg-light text-dark fs-6">
                    {{ $summaryReject->total() }}
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
                        @if ($summaryReject->count() < 1)
                            <tr>
                                <td colspan='8'>Reject tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($summaryReject as $row)
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
                    {{ $summaryReject->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div class="modal" tabindex="-1" id="reject-modal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-reject text-light">
                    <h5 class="modal-title">REJECT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            @error('rejectType')
                                <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                                    <small>
                                        <strong>Error</strong> {{$message}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </small>
                                </div>
                            @enderror
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label me-1 mb-0">Reject Type</label>
                            </div>
                            <div wire:ignore id="select-reject-type-container">
                                <select class="form-select @error('rejectType') is-invalid @enderror" id="reject-type-select2" wire:model='rejectType'>
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
                            @error('rejectArea')
                                <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                                    <small>
                                        <strong>Error</strong> {{$message}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </small>
                                </div>
                            @enderror
                            <div class="d-flex align-items-center mb-1">
                                <label class="form-label me-1 mb-0">Reject Area</label>
                            </div>
                            <div class="d-flex gap-1">
                                <div class="w-75" wire:ignore id="select-reject-area-container">
                                    <select class="form-select @error('rejectArea') is-invalid @enderror" id="reject-area-select2" wire:model='rejectArea'>
                                        <option value="" selected>Select defect area</option>
                                        @foreach ($defectAreas as $defect)
                                            <option value="{{ $defect->id }}">
                                                {{ $defect->defect_area }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-25">
                                    <button type="button" wire:click="selectRejectAreaPosition" class="btn btn-dark w-100">
                                        <i class="fa-regular fa-image"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            @if ($errors->has('rejectAreaPositionX') || $errors->has('rejectAreaPositionY'))
                                <div class="alert alert-danger alert-dismissible fade show mb-0 rounded-0" role="alert">
                                    <small>
                                        <strong>Error</strong> Harap tentukan posisi reject area dengan mengklik tombol <button type="button"class="btn btn-dark btn-sm"><i class="fa-regular fa-image fa-2xs"></i></button> di samping 'select defect area'.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </small>
                                </div>
                            @endif
                            <div class="d-none">
                                <label class="form-label me-1 mb-2">Reject Area Position</label>
                                <div class="row">
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <label class="form-label me-1 mb-0">X </label>
                                        <div class="d-flex">
                                            <input class="form-control @error('rejectAreaPositionX') is-invalid @enderror" id="reject-area-position-x-livewire" wire:model='rejectAreaPositionX' readonly>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <label class="form-label me-1 mb-1">Y </label>
                                        <div class="d-flex">
                                            <input class="form-control @error('rejectAreaPositionY') is-invalid @enderror" id="reject-area-position-y-livewire" wire:model='rejectAreaPositionY' readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" wire:click='submitInput'>Selesai</button>
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
            // Defect Type
            $('#reject-type-select2').select2({
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                dropdownParent: $('#reject-modal .modal-content #select-reject-type-container')
            });

            $('#reject-type-select2').on('change', function (e) {
                var rejectType = $('#reject-type-select2').select2("val");
                @this.set('rejectType', rejectType);
            });

            // Defect Area
            $('#reject-area-select2').select2({
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                dropdownParent: $('#reject-modal .modal-content #select-reject-area-container')
            });

            $('#reject-area-select2').on('change', function (e) {
                var rejectArea = $('#reject-area-select2').select2("val");
                @this.set('rejectArea', rejectArea);
            });

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            Livewire.on('clearSelectRejectAreaPoint', () => {
                $('#reject-type-select2').val("").trigger('change');
                $('#reject-area-select2').val("").trigger('change');
            });

            document.getElementById('reject-input').addEventListener("keyup", async (event) => {
                if (event.key === 'Enter' || event.keyCode === 13) {
                    await @this.preSubmitInput();
                    let el = document.querySelector( ':focus' );
                    if( el ) el.blur();
                }
            });
        })

        Livewire.on('setRejectData', (data) => {
            setTimeout(() => {
                $('#reject-type-select2').val(data.type).trigger('change');
                $('#reject-area-select2').val(data.area).trigger('change');

                $('#reject-area-position-x-livewire').val(data.x);
                $('#reject-area-position-y-livewire').val(data.y);
            }, 100);
        });
    </script>
@endpush