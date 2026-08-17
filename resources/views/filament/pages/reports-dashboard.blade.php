<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header --}}
        <div class="rounded-2xl bg-gradient-to-r from-emerald-700 via-emerald-600 to-green-500 p-6 text-white shadow-lg">
            <h2 class="text-2xl font-bold tracking-tight">Hospital Reports & Statistics Dashboard</h2>
            <p class="mt-1 text-emerald-50">Federal University Teaching Hospital, Lafia — Comprehensive analytics across all departments, units, and users</p>
            <p class="mt-1 text-emerald-100 text-sm">Generated: {{ now()->format('M d, Y H:i') }} (Africa/Lagos)</p>
        </div>

        {{-- Top-level KPI Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4">
                <p class="text-xs text-emerald-700 uppercase tracking-wide">Patients</p>
                <p class="text-2xl font-bold text-emerald-900">{{ number_format($patientStats['total']) }}</p>
                <p class="text-xs text-gray-500 mt-1">+{{ $patientStats['new_this_month'] }} this month</p>
            </div>
            <div class="rounded-xl bg-info-50 border border-info-200 p-4">
                <p class="text-xs text-info-700 uppercase tracking-wide">Encounters</p>
                <p class="text-2xl font-bold text-info-900">{{ number_format($encounterStats['total']) }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $encounterStats['today'] }} today</p>
            </div>
            <div class="rounded-xl bg-success-50 border border-success-200 p-4">
                <p class="text-xs text-success-700 uppercase tracking-wide">Revenue (Year)</p>
                <p class="text-xl font-bold text-success-900">₦{{ number_format((float) $financialStats['revenue_year'], 0) }}</p>
                <p class="text-xs text-gray-500 mt-1">₦{{ number_format((float) $financialStats['revenue_today'], 0) }} today</p>
            </div>
            <div class="rounded-xl bg-amber-50 border border-amber-200 p-4">
                <p class="text-xs text-amber-700 uppercase tracking-wide">Bed Occupancy</p>
                <p class="text-2xl font-bold text-amber-900">{{ $wardStats['occupancy_pct'] }}%</p>
                <p class="text-xs text-gray-500 mt-1">{{ $wardStats['beds_occupied'] }}/{{ $wardStats['beds'] }} beds</p>
            </div>
            <div class="rounded-xl bg-rose-50 border border-rose-200 p-4">
                <p class="text-xs text-rose-700 uppercase tracking-wide">Insurance Claims</p>
                <p class="text-2xl font-bold text-rose-900">{{ number_format($insuranceStats['pending_claims']) }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $insuranceStats['paid_claims'] }} paid</p>
            </div>
            <div class="rounded-xl bg-purple-50 border border-purple-200 p-4">
                <p class="text-xs text-purple-700 uppercase tracking-wide">Staff</p>
                <p class="text-2xl font-bold text-purple-900">{{ number_format($hrStats['staff']) }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $hrStats['on_leave'] }} on leave</p>
            </div>
        </div>

        {{-- Monthly Trends --}}
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-700">12-Month Activity Trends</h3>
                <p class="text-xs text-gray-500">Patients registered, encounters, and revenue by month</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                            <th class="py-2 pr-4">Month</th>
                            <th class="py-2 pr-4">New Patients</th>
                            <th class="py-2 pr-4">Encounters</th>
                            <th class="py-2 pr-4">Revenue (₦)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlyTrends as $trend)
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="py-2 pr-4 font-medium text-gray-900">{{ $trend['month'] }}</td>
                                <td class="py-2 pr-4 text-emerald-700 font-semibold">{{ number_format($trend['patients']) }}</td>
                                <td class="py-2 pr-4 text-info-700 font-semibold">{{ number_format($trend['encounters']) }}</td>
                                <td class="py-2 pr-4 text-success-700 font-semibold">₦{{ number_format((float) $trend['revenue'], 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Departmental Statistics --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">Departmental Statistics</h3>
                    <p class="text-xs text-gray-500">Staff distribution by department</h3>
                </div>
                @if (!empty($departmentStats))
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                                    <th class="py-2 pr-4">Department</th>
                                    <th class="py-2 pr-4">Code</th>
                                    <th class="py-2 pr-4">Staff</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departmentStats as $dept)
                                    <tr class="border-b border-gray-50 last:border-0">
                                        <td class="py-2 pr-4 font-medium text-gray-900">{{ $dept['name'] }}</td>
                                        <td class="py-2 pr-4 text-gray-600">{{ $dept['code'] }}</td>
                                        <td class="py-2 pr-4"><x-filament::badge color="success">{{ $dept['staff_count'] }}</x-filament::badge></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No department data available.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">User Activity</h3>
                    <p class="text-xs text-gray-500">Active users and their roles</h3>
                </div>
                @if (!empty($userStats))
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs uppercase tracking-wider text-gray-500 border-b border-gray-100">
                                    <th class="py-2 pr-4">User</th>
                                    <th class="py-2 pr-4">Role</th>
                                    <th class="py-2 pr-4">Last Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userStats as $u)
                                    <tr class="border-b border-gray-50 last:border-0">
                                        <td class="py-2 pr-4">
                                            <p class="font-medium text-gray-900">{{ $u['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $u['email'] }}</p>
                                        </td>
                                        <td class="py-2 pr-4"><x-filament::badge color="info">{{ $u['role'] }}</x-filament::badge></td>
                                        <td class="py-2 pr-4 text-gray-600 text-xs">{{ $u['last_login'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No user activity data.</p>
                @endif
            </div>
        </div>

        {{-- Detailed Module Statistics --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {{-- Patient Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-gray-700">Patient Demographics</h3></div>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Total Patients</span><span class="font-bold">{{ $patientStats['total'] }}</span></li>
                    <li class="flex justify-between"><span>Male</span><span class="font-bold text-info-700">{{ $patientStats['male'] }}</span></li>
                    <li class="flex justify-between"><span>Female</span><span class="font-bold text-rose-700">{{ $patientStats['female'] }}</span></li>
                    <li class="flex justify-between"><span>New (This Month)</span><span class="font-bold text-emerald-700">{{ $patientStats['new_this_month'] }}</span></li>
                    <li class="flex justify-between"><span>Verified (Biometric)</span><span class="font-bold text-success-700">{{ $patientStats['verified'] }}</span></li>
                    <li class="flex justify-between"><span>Pending Verification</span><span class="font-bold text-amber-700">{{ $patientStats['pending_verification'] }}</span></li>
                </ul>
            </div>

            {{-- Encounter Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-gray-700">Encounters by Type</h3></div>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Total</span><span class="font-bold">{{ $encounterStats['total'] }}</span></li>
                    <li class="flex justify-between"><span>Outpatient</span><span class="font-bold">{{ $encounterStats['outpatient'] }}</span></li>
                    <li class="flex justify-between"><span>Emergency</span><span class="font-bold text-rose-700">{{ $encounterStats['emergency'] }}</span></li>
                    <li class="flex justify-between"><span>Inpatient</span><span class="font-bold text-amber-700">{{ $encounterStats['inpatient'] }}</span></li>
                    <li class="flex justify-between"><span>Telemedicine</span><span class="font-bold text-info-700">{{ $encounterStats['telemedicine'] }}</span></li>
                    <li class="flex justify-between"><span>Completed</span><span class="font-bold text-success-700">{{ $encounterStats['completed'] }}</span></li>
                </ul>
            </div>

            {{-- Financial Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-gray-700">Financial Summary</h3></div>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Revenue (Today)</span><span class="font-bold text-success-700">₦{{ number_format((float) $financialStats['revenue_today'], 0) }}</span></li>
                    <li class="flex justify-between"><span>Revenue (Month)</span><span class="font-bold text-success-700">₦{{ number_format((float) $financialStats['revenue_month'], 0) }}</span></li>
                    <li class="flex justify-between"><span>Revenue (Year)</span><span class="font-bold text-success-700">₦{{ number_format((float) $financialStats['revenue_year'], 0) }}</span></li>
                    <li class="flex justify-between"><span>Outstanding</span><span class="font-bold text-rose-700">₦{{ number_format((float) $financialStats['outstanding'], 0) }}</span></li>
                    <li class="flex justify-between"><span>Total Assets</span><span class="font-bold">₦{{ number_format((float) $financialStats['total_assets'], 0) }}</span></li>
                    <li class="flex justify-between"><span>Total Liabilities</span><span class="font-bold">₦{{ number_format((float) $financialStats['total_liabilities'], 0) }}</span></li>
                </ul>
            </div>

            {{-- Pharmacy Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-gray-700">Pharmacy</h3></div>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Total Drugs</span><span class="font-bold">{{ $pharmacyStats['total_drugs'] }}</span></li>
                    <li class="flex justify-between"><span>Low Stock</span><span class="font-bold text-amber-700">{{ $pharmacyStats['low_stock'] }}</span></li>
                    <li class="flex justify-between"><span>Prescriptions</span><span class="font-bold">{{ $pharmacyStats['prescriptions'] }}</span></li>
                    <li class="flex justify-between"><span>Pending Dispensing</span><span class="font-bold text-rose-700">{{ $pharmacyStats['pending_dispensing'] }}</span></li>
                    <li class="flex justify-between"><span>Dispensed</span><span class="font-bold text-success-700">{{ $pharmacyStats['dispensed'] }}</span></li>
                </ul>
            </div>

            {{-- Lab Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-gray-700">Laboratory</h3></div>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Total Orders</span><span class="font-bold">{{ $labStats['total_orders'] }}</span></li>
                    <li class="flex justify-between"><span>Pending</span><span class="font-bold text-amber-700">{{ $labStats['pending'] }}</span></li>
                    <li class="flex justify-between"><span>In Progress</span><span class="font-bold text-info-700">{{ $labStats['in_progress'] }}</span></li>
                    <li class="flex justify-between"><span>Completed</span><span class="font-bold text-success-700">{{ $labStats['completed'] }}</span></li>
                    <li class="flex justify-between"><span>Verified</span><span class="font-bold text-emerald-700">{{ $labStats['verified'] }}</span></li>
                </ul>
            </div>

            {{-- Radiology Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-gray-700">Radiology</h3></div>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Total Orders</span><span class="font-bold">{{ $radiologyStats['total_orders'] }}</span></li>
                    <li class="flex justify-between"><span>Pending</span><span class="font-bold text-amber-700">{{ $radiologyStats['pending'] }}</span></li>
                    <li class="flex justify-between"><span>Completed</span><span class="font-bold text-success-700">{{ $radiologyStats['completed'] }}</span></li>
                    <li class="flex justify-between"><span>Verified</span><span class="font-bold text-emerald-700">{{ $radiologyStats['verified'] }}</span></li>
                </ul>
            </div>

            {{-- Insurance Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-gray-700">Insurance</h3></div>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Providers</span><span class="font-bold">{{ $insuranceStats['providers'] }}</span></li>
                    <li class="flex justify-between"><span>Plans</span><span class="font-bold">{{ $insuranceStats['plans'] }}</span></li>
                    <li class="flex justify-between"><span>Active Policies</span><span class="font-bold text-success-700">{{ $insuranceStats['active_policies'] }}</span></li>
                    <li class="flex justify-between"><span>Pending Claims</span><span class="font-bold text-amber-700">{{ $insuranceStats['pending_claims'] }}</span></li>
                    <li class="flex justify-between"><span>Approved Claims</span><span class="font-bold text-info-700">{{ $insuranceStats['approved_claims'] }}</span></li>
                    <li class="flex justify-between"><span>Paid Claims</span><span class="font-bold text-success-700">{{ $insuranceStats['paid_claims'] }}</span></li>
                </ul>
            </div>

            {{-- Blood Bank Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-gray-700">Blood Bank</h3></div>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Donors</span><span class="font-bold">{{ $bloodBankStats['donors'] }}</span></li>
                    <li class="flex justify-between"><span>Donations</span><span class="font-bold">{{ $bloodBankStats['donations'] }}</span></li>
                    <li class="flex justify-between"><span>Units Available</span><span class="font-bold text-success-700">{{ $bloodBankStats['units_available'] }}</span></li>
                    <li class="flex justify-between"><span>Units Transfused</span><span class="font-bold text-info-700">{{ $bloodBankStats['units_transfused'] }}</span></li>
                    <li class="flex justify-between"><span>Pending Requests</span><span class="font-bold text-amber-700">{{ $bloodBankStats['pending_requests'] }}</span></li>
                </ul>
            </div>

            {{-- Audit Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4"><h3 class="text-sm font-semibold text-gray-700">Audit</h3></div>
                <ul class="space-y-2 text-sm">
                    <li class="flex justify-between"><span>Medical Audits</span><span class="font-bold">{{ $auditStats['medical_audits'] }}</span></li>
                    <li class="flex justify-between"><span>Internal Audits</span><span class="font-bold">{{ $auditStats['internal_audits'] }}</span></li>
                    <li class="flex justify-between"><span>Open Findings</span><span class="font-bold text-amber-700">{{ $auditStats['open_findings'] }}</span></li>
                    <li class="flex justify-between"><span>Critical Findings</span><span class="font-bold text-rose-700">{{ $auditStats['critical_findings'] }}</span></li>
                </ul>
            </div>
        </div>
    </div>
</x-filament-panels::page>
