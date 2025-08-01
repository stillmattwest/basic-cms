@props([
    'disabled' => false,
    'error' => null,
    'label' => null,
    'required' => false,
    'helpText' => null,
])

@php
    $inputId = $attributes->get('id') ?: 'date_' . uniqid();
    $inputName = $attributes->get('name') ?: 'date';
    $value = $attributes->get('value') ?: old($inputName);
@endphp

<div class="mb-4" x-data="datePickerComponent('{{ $inputId }}', '{{ $value }}', {{ $disabled ? 'true' : 'false' }})">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        <input 
            type="text"
            id="{{ $inputId }}"
            name="{{ $inputName }}"
            x-model="displayValue"
            @click="openPicker()"
            @keydown.escape="closePicker()"
            readonly
            placeholder="Select a date"
            {{ $disabled ? 'disabled' : '' }}
            {{ $required ? 'required' : '' }}
            {!! $attributes->except(['type', 'id', 'name', 'value'])->merge(['class' => 'block w-full px-3 py-2 pr-10 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed cursor-pointer' . ($error ? ' border-red-500 focus:ring-red-500 focus:border-red-500' : '')]) !!}
        />
        
        <!-- Calendar Icon -->
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <button type="button" @click="openPicker()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-150" :disabled="disabled">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>

        <!-- Hidden input for form submission -->
        <input type="hidden" x-model="actualValue" name="{{ $inputName }}_actual" />
    </div>
    
    <!-- Date Picker Dropdown -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         @click.away="closePicker()"
         class="absolute z-50 mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-lg p-4 w-80">
        
        <!-- Month/Year Navigation -->
        <div class="flex items-center justify-between mb-4">
            <button type="button" @click="previousMonth()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </button>
            
            <h3 class="text-lg font-medium text-gray-900 dark:text-white" x-text="currentMonthYear"></h3>
            
            <button type="button" @click="nextMonth()" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
        
        <!-- Calendar Grid -->
        <div class="grid grid-cols-7 gap-1 text-center text-sm">
            <!-- Day Headers -->
            <template x-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
                <div class="py-2 text-gray-500 dark:text-gray-400 font-medium" x-text="day"></div>
            </template>
            
            <!-- Calendar Days -->
            <template x-for="day in calendarDays" :key="day.date">
                <button type="button" 
                        @click="selectDate(day.date)"
                        :disabled="!day.isCurrentMonth"
                        :class="{
                            'bg-primary-600 text-white': day.isSelected,
                            'hover:bg-primary-100 dark:hover:bg-primary-800': day.isCurrentMonth && !day.isSelected,
                            'text-gray-900 dark:text-white': day.isCurrentMonth && !day.isSelected,
                            'text-gray-400 dark:text-gray-600': !day.isCurrentMonth,
                            'bg-primary-50 dark:bg-primary-900': day.isToday && !day.isSelected
                        }"
                        class="py-2 px-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150 disabled:cursor-not-allowed"
                        x-text="day.day">
                </button>
            </template>
        </div>
        
        <!-- Today Button -->
        <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-600">
            <button type="button" 
                    @click="selectToday()"
                    class="w-full px-3 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900 rounded transition-colors duration-150">
                Today
            </button>
        </div>
    </div>
    
    @if($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif
    
    @if($error)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('datePickerComponent', (inputId, initialValue, disabled) => ({
        isOpen: false,
        displayValue: '',
        actualValue: '',
        currentDate: new Date(),
        selectedDate: null,
        calendarDays: [],
        currentMonthYear: '',
        disabled: disabled,

        init() {
            this.setInitialValue(initialValue);
            this.updateCalendar();
        },

        setInitialValue(value) {
            if (value) {
                // Handle YYYY-MM-DD format properly in local timezone
                if (value.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    const [year, month, day] = value.split('-').map(Number);
                    const date = new Date(year, month - 1, day);
                    this.selectedDate = date;
                    this.currentDate = new Date(date);
                    this.displayValue = this.formatDate(date);
                    this.actualValue = this.formatDateForInput(date);
                } else {
                    // Fallback for other date formats
                    const date = new Date(value);
                    if (!isNaN(date.getTime())) {
                        this.selectedDate = date;
                        this.currentDate = new Date(date);
                        this.displayValue = this.formatDate(date);
                        this.actualValue = this.formatDateForInput(date);
                    }
                }
            }
        },

        openPicker() {
            if (this.disabled) return;
            this.isOpen = true;
            this.updateCalendar();
        },

        closePicker() {
            this.isOpen = false;
        },

        previousMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() - 1);
            this.updateCalendar();
        },

        nextMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() + 1);
            this.updateCalendar();
        },

        selectDate(dateString) {
            // Create date from the YYYY-MM-DD string in local timezone
            const [year, month, day] = dateString.split('-').map(Number);
            const date = new Date(year, month - 1, day);
            this.selectedDate = date;
            this.displayValue = this.formatDate(date);
            this.actualValue = this.formatDateForInput(date);
            this.closePicker();
        },

        selectToday() {
            const today = new Date();
            this.selectedDate = today;
            this.currentDate = new Date(today);
            this.displayValue = this.formatDate(today);
            this.actualValue = this.formatDateForInput(today);
            this.updateCalendar();
            this.closePicker();
        },

        formatDate(date) {
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },

        formatDateForInput(date) {
            // Use local timezone to avoid off-by-one day issues
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

        updateCalendar() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            
            // Update month/year display
            this.currentMonthYear = this.currentDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long'
            });

            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());

            // Generate calendar days
            this.calendarDays = [];
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);
                
                const isCurrentMonth = date.getMonth() === month;
                const isToday = date.getTime() === today.getTime();
                const isSelected = this.selectedDate && 
                    date.getTime() === new Date(this.selectedDate.getFullYear(), this.selectedDate.getMonth(), this.selectedDate.getDate()).getTime();

                this.calendarDays.push({
                    date: date.toISOString().split('T')[0],
                    day: date.getDate(),
                    isCurrentMonth,
                    isToday,
                    isSelected
                });
            }
        }
    }));
});
</script>
@endpush
