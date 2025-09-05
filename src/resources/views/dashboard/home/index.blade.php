@extends('dashboard.layout.master')
@section('title', 'پیشخوان')
@section('content')
    <div class="container-fluid">
        <!-- کارت‌های آماری -->
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">تعداد دانشجویان</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">1,247</h4>
                                    <small class="text-success">+12%</small>
                                </div>
                                <small class="text-muted">نسبت به ماه گذشته</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded p-2">
                                    <i class="ti ti-users ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">تعداد دوره‌ها</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">89</h4>
                                    <small class="text-success">+8%</small>
                                </div>
                                <small class="text-muted">دوره‌های فعال</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-info rounded p-2">
                                    <i class="ti ti-book ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">فعالیت‌های امروز</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">342</h4>
                                    <small class="text-warning">+5%</small>
                                </div>
                                <small class="text-muted">تسک‌های انجام شده</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded p-2">
                                    <i class="ti ti-activity ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="card-info">
                                <p class="card-text">درآمد ماهانه</p>
                                <div class="d-flex align-items-end mb-2">
                                    <h4 class="card-title mb-0 me-2">۲۴۵M</h4>
                                    <small class="text-success">+18%</small>
                                </div>
                                <small class="text-muted">تومان</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-success rounded p-2">
                                    <i class="ti ti-currency-dollar ti-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- نمودار حضور و غیاب -->
            <div class="col-xl-8 col-lg-7 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-0">آمار حضور و غیاب</h5>
                            <small class="text-muted">هفته جاری</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="attendanceMenuBtn" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);">مشاهده جزئیات</a>
                                <a class="dropdown-item" href="javascript:void(0);">گزارش کامل</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="attendanceChart" style="min-height: 380px;"></div>
                    </div>
                </div>
            </div>

            <!-- اعلانات و اطلاعیه‌ها -->
            <div class="col-xl-4 col-lg-5 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">اعلانات مهم</h5>
                        <span class="badge bg-primary">۵ مورد جدید</span>
                    </div>
                    <div class="card-body">
                        <div class="timeline timeline-advance">
                            <div class="timeline-item">
                                <span class="timeline-indicator timeline-indicator-success">
                                    <i class="ti ti-bell"></i>
                                </span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">شروع ثبت‌نام ترم جدید</h6>
                                        <small class="text-muted">۲ ساعت پیش</small>
                                    </div>
                                    <p class="mb-2">ثبت‌نام دوره‌های ترم بهار آغاز شد</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <span class="timeline-indicator timeline-indicator-warning">
                                    <i class="ti ti-alert-triangle"></i>
                                </span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">تعطیلی سیستم</h6>
                                        <small class="text-muted">۱ روز پیش</small>
                                    </div>
                                    <p class="mb-2">نگهداری سیستم شنبه ۱۰-۱۲</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <span class="timeline-indicator timeline-indicator-info">
                                    <i class="ti ti-info-circle"></i>
                                </span>
                                <div class="timeline-event">
                                    <div class="timeline-header mb-1">
                                        <h6 class="mb-0">بروزرسانی سیستم</h6>
                                        <small class="text-muted">۳ روز پیش</small>
                                    </div>
                                    <p class="mb-0">ویژگی‌های جدید اضافه شد</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- آخرین فعالیت‌های آموزشی -->
            <div class="col-xl-8 col-lg-7 col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">آخرین فعالیت‌های آموزشی</h5>
                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary">مشاهده همه</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>دانشجو</th>
                                        <th>دوره</th>
                                        <th>فعالیت</th>
                                        <th>زمان</th>
                                        <th>وضعیت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <span class="avatar-initial rounded-circle bg-label-primary">ع.ا</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">علی احمدی</h6>
                                                    <small class="text-muted">دانشجو</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>برنامه‌نویسی پایتون</td>
                                        <td>تکمیل تمرین ۵</td>
                                        <td>۱۰ دقیقه پیش</td>
                                        <td><span class="badge bg-label-success">تکمیل شده</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <span class="avatar-initial rounded-circle bg-label-info">س.م</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">سارا محمدی</h6>
                                                    <small class="text-muted">دانشجو</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>طراحی گرافیک</td>
                                        <td>ارسال پروژه</td>
                                        <td>۳۰ دقیقه پیش</td>
                                        <td><span class="badge bg-label-warning">در انتظار بررسی</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <span class="avatar-initial rounded-circle bg-label-warning">م.ر</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">محمد رضایی</h6>
                                                    <small class="text-muted">دانشجو</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>شبکه کامپیوتر</td>
                                        <td>شرکت در آزمون</td>
                                        <td>۱ ساعت پیش</td>
                                        <td><span class="badge bg-label-success">قبول</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- تقویم آموزشی -->
            <div class="col-xl-4 col-lg-5 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">تقویم آموزشی</h5>
                        <small class="text-muted">رویدادهای مهم</small>
                    </div>
                    <div class="card-body">
                        <div class="calendar-wrapper">
                            <div class="calendar-header mb-3">
                                <h6 class="mb-0">دی ماه ۱۴۰۳</h6>
                            </div>
                            <div class="calendar-events">
                                <div class="event-item mb-3 p-3 rounded"
                                    style="background-color: #f8f9fa; border-right: 4px solid #007bff;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">آزمون میان‌ترم</h6>
                                            <small class="text-muted">برنامه‌نویسی جاوا</small>
                                        </div>
                                        <span class="badge bg-primary">۱۵ دی</span>
                                    </div>
                                </div>
                                <div class="event-item mb-3 p-3 rounded"
                                    style="background-color: #f8f9fa; border-right: 4px solid #28a745;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">پایان ثبت‌نام</h6>
                                            <small class="text-muted">دوره‌های ترم بهار</small>
                                        </div>
                                        <span class="badge bg-success">۲۰ دی</span>
                                    </div>
                                </div>
                                <div class="event-item mb-3 p-3 rounded"
                                    style="background-color: #f8f9fa; border-right: 4px solid #ffc107;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">کارگاه آموزشی</h6>
                                            <small class="text-muted">هوش مصنوعی</small>
                                        </div>
                                        <span class="badge bg-warning">۲۵ دی</span>
                                    </div>
                                </div>
                                <div class="event-item mb-3 p-3 rounded"
                                    style="background-color: #f8f9fa; border-right: 4px solid #dc3545;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">آزمون پایان‌ترم</h6>
                                            <small class="text-muted">تمام دوره‌ها</small>
                                        </div>
                                        <span class="badge bg-danger">۳۰ دی</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
    @vite(['resources/assets/vendor/css/apex-charts.css', 'resources/assets/vendor/js/apexcharts.js'])
@endsection

@push('scripts')
    <script type="module">
        // اطمینان از موجود بودن ApexCharts روی window (برای Vite)
        window.ApexCharts = ApexCharts;

        // رفع مشکل دیده نشدن کامل legend: انتقال legend به پایین و تنظیم فاصله‌ها
        var attendanceOptions = {
            series: [{
                name: 'حضور',
                type: 'column',
                data: [245, 287, 198, 234, 312, 267, 289, 301]
            }, {
                name: 'غیاب',
                type: 'column',
                data: [45, 23, 67, 34, 18, 43, 31, 22]
            }, {
                name: 'درصد حضور',
                type: 'line',
                data: [84.5, 92.6, 74.7, 87.3, 94.5, 86.1, 90.3, 93.2]
            }],
            chart: {
                height: 420,
                type: 'line',
                stacked: false,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            stroke: {
                width: [0, 0, 4],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '65%',
                    endingShape: 'rounded',
                    borderRadius: 4
                }
            },
            fill: {
                opacity: [0.85, 0.85, 1],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: ['شنبه ۱۰ دی', 'یکشنبه ۱۱ دی', 'دوشنبه ۱۲ دی', 'سه‌شنبه ۱۳ دی', 'چهارشنبه ۱۴ دی', 'پنج‌شنبه ۱۵ دی',
                'جمعه ۱۶ دی', 'شنبه ۱۷ دی'
            ],
            markers: {
                size: 0
            },
            xaxis: {
                type: 'category',
                categories: ['شنبه ۱۰ دی', 'یکشنبه ۱۱ دی', 'دوشنبه ۱۲ دی', 'سه‌شنبه ۱۳ دی', 'چهارشنبه ۱۴ دی',
                    'پنج‌شنبه ۱۵ دی', 'جمعه ۱۶ دی', 'شنبه ۱۷ دی'
                ],
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                },
                tickAmount: 8
            },
            yaxis: [{
                title: {
                    text: 'تعداد دانشجو',
                    style: {
                        color: '#28a745'
                    }
                },
                labels: {
                    style: {
                        colors: '#28a745'
                    }
                }
            }, {
                opposite: true,
                title: {
                    text: 'درصد حضور',
                    style: {
                        color: '#007bff'
                    }
                },
                labels: {
                    style: {
                        colors: '#007bff'
                    },
                    formatter: function(val) {
                        return val + "%"
                    }
                }
            }],
            tooltip: {
                shared: true,
                intersect: false,
                y: [{
                    formatter: function(y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " نفر";
                        }
                        return y;
                    }
                }, {
                    formatter: function(y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " نفر";
                        }
                        return y;
                    }
                }, {
                    formatter: function(y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(1);
                        }
                        return y;
                    }
                }]
            },
            colors: ['#28a745', '#dc3545', '#007bff'],
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                offsetY: 8,
                fontSize: '13px',
                markers: {
                    width: 10,
                    height: 10
                },
                itemMargin: {
                    horizontal: 12,
                    vertical: 6
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        labels: {
                            show: false,
                            total: {
                                show: true,
                                label: 'میانگین حضور',
                                formatter: function() {
                                    return '87.2%'
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val.toFixed(1)
                }
            }
        };

        // اطمینان از wrap شدن آیتم‌های legend و سازگاری با RTL
        const apexLegendStyle = document.createElement('style');
        apexLegendStyle.innerHTML = `
            .apexcharts-legend{flex-wrap:wrap !important; direction: rtl;}
            .apexcharts-legend.position-bottom{justify-content:center !important;}
            .apexcharts-legend-series{margin:4px 10px !important;}
        `;
        document.head.appendChild(apexLegendStyle);

        var attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions);
        attendanceChart.render();

        // چارت دایره‌ای برای آمار کلی حضور
        var overallAttendanceOptions = {
            series: [87.2, 12.8],
            chart: {
                width: 200,
                type: 'donut',
            },
            labels: ['حضور', 'غیاب'],
            colors: ['#28a745', '#dc3545'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        labels: {
                            show: false,
                            total: {
                                show: true,
                                label: 'میانگین حضور',
                                formatter: function() {
                                    return '87.2%'
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val.toFixed(1) + "%"
                }
            }
        };

        // اضافه کردن چارت دایره‌ای به کنار چارت اصلی
        setTimeout(() => {
            const chartContainer = document.querySelector('#attendanceChart').parentElement;
            if (chartContainer && chartContainer.offsetWidth >= 900) {
                const donutContainer = document.createElement('div');
                donutContainer.id = 'overallAttendanceChart';
                donutContainer.style.cssText =
                    'position: absolute; top: 16px; right: 16px; background: white; border-radius: 8px; padding: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);';
                chartContainer.style.position = 'relative';
                chartContainer.appendChild(donutContainer);
                var overallChart = new ApexCharts(document.querySelector('#overallAttendanceChart'),
                    overallAttendanceOptions);
                overallChart.render();
            }
        }, 800);

        // انیمیشن برای کارت‌های آماری
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
@endpush

{{-- حذف سکشن تکراری vendor-script که در انتهای فایل بود --}}
@section('vendor-script')
    @vite(['resources/assets/vendor/css/apex-charts.css', 'resources/assets/vendor/js/apexcharts.js'])
@endsection
