import '../css/app.css'

import Alpine from 'alpinejs'
import Chart from 'chart.js/auto'
import FormsAlpinePlugin from '../../../laravel-filament-forms/dist/module.esm'
import Trap from '@alpinejs/trap'

Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(Trap)

Alpine.store('sidebar', {
    isOpen: false,

    close() {
        this.isOpen = false
    },

    open() {
        this.isOpen = true
    },
})

Chart.defaults.font.family = `'DM Sans', sans-serif`
Chart.defaults.backgroundColor = '#737373'

window.Alpine = Alpine
window.Chart = Chart

Alpine.start()
