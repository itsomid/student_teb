@extends('dashboard.layout.master')
@section('title', 'ویرایش نرخ تخصیص دانشجو به پشتیبان')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body border-bottom">
                <h5 class="card-title">ویرایش نرخ تخصیص دانشجو به پشتیبان</h5>
            </div>
        </div>
    </div>


    <form class="row my-5" action="{{route('admin.supports-allocation-rate.update')}}" method="post" >
        @csrf
        @method('PATCH')
        @foreach($maps as $map)
            <div class="col-md-12">
                <h6> 👈 پشتیبان های {{$map->title}} </h6>
            </div>
            @foreach($map->admins as $support)
                <div class="col-md-4 my-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-6">
                                    <label class="switch switch-primary">
                                        <input type="checkbox"
                                               class="switch-input"
                                               data-input_id="allocation_rate_{{$support->id}}"
                                               data-label_id="label_for_{{$support->id}}"
                                               name="is_active[{{$support->id}}]"
                                               {{  $support->allocationRate->last()?->is_active ? 'checked' : ''}}
                                        />
                                        <span class="switch-toggle-slider">
                                                <span class="switch-on">
                                                  <i class="ti ti-check"></i>
                                                </span>
                                                <span class="switch-off">
                                                  <i class="ti ti-x"></i>
                                                </span>
                                            </span>
                                        <span class="switch-label" id="label_for_{{$support->id}}"> {{$support->fullname()}}</span>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="allocation_rate_{{$support->id}}"> نرخ تخصیص</label>
                                        <input id="allocation_rate_{{$support->id}}"
                                               class="form-control"
                                               type="number"
                                               step="1"
                                               name="allocation_rate[{{$support->id}}]"
                                               value="{{$support->allocationRate->last()->allocation_rate ?? 1 }}"
                                            {{  $support->allocationRate->last()?->is_active ? '' : 'disabled'}}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary text-white">ثبت تغییرات</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.getElementsByTagName('input');

            for (let input of inputs) {
                if (input.type === 'checkbox') {
                    input.addEventListener('change', function() {
                        const inputId = this.getAttribute('data-input_id');
                        const labelId = this.getAttribute('data-label_id');
                        console.log(labelId);
                        const label = document.getElementById(labelId);
                        const targetInput = document.getElementById(inputId);

                        if (this.checked) {
                            label.classList.remove('text-muted');
                            targetInput.removeAttribute('disabled');
                        } else {
                            label.classList.add('text-muted');
                            targetInput.setAttribute('disabled', 'disabled');
                        }
                    });
                }
            }
        });
    </script>
@endsection
