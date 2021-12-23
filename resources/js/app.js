import '../css/app.css'

import Alpine from 'alpinejs'
import Chart from 'chart.js/auto'
import FormsAlpinePlugin from '../../../laravel-filament-forms/dist/module.esm'
import Focus from '@alpinejs/focus'
import Persist from '@alpinejs/persist'
import Collapse from '@alpinejs/collapse'
import "./uppy"

Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(Focus)
Alpine.plugin(Persist)
Alpine.plugin(Collapse)

Alpine.store('sidebar', {
    isOpen: false,

    collapsedGroups: Alpine.$persist([]).as('collapsedGroups'),

    groupIsCollapsed(group) {
        return this.collapsedGroups.includes(group)
    },

    toggleCollapsedGroup(group) {
        this.collapsedGroups = this.collapsedGroups.includes(group) ?
            this.collapsedGroups.filter(g => g !== group) :
            this.collapsedGroups.concat(group)
    },

    close() {
        this.isOpen = false
    },

    open() {
        this.isOpen = true
    },
})

Alpine.store('mediaLibrary', {
    uploadProgress: 0,
    showProgress: false,
    setUploadProgress(value) {
        this.uploadProgress = value
    },
    showProgressBar() {
        this.showProgress = true
    },
    hideProgressBar() {
        this.showProgress = false
    },
});

Chart.defaults.font.family = `'DM Sans', sans-serif`
Chart.defaults.backgroundColor = '#737373'

window.Alpine = Alpine
window.Chart = Chart

Alpine.start()
