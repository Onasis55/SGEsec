<template>
    <div class="behavior-reports-container">
        <!-- Header del estudiante -->
        <div class="student-header">
            <h1 class="title">Reportes de Conducta</h1>
            <div class="student-info">
                <h2>{{ studentInfo.name }} {{ studentInfo.lastName }}</h2>
                <p class="student-details">
                    Matrícula: {{ studentInfo.enrollment }} |
                    Grado: {{ studentInfo.grade }} |
                    Grupo: {{ studentInfo.group }}
                </p>
            </div>
        </div>

        <!-- Loading state -->
        <div v-if="loading" class="loading">
            <div class="spinner"></div>
            <p>Cargando reportes...</p>
        </div>

        <!-- Error state -->
        <div v-if="error" class="error-message">
            <p>{{ error }}</p>
            <button @click="fetchReports" class="retry-btn">Reintentar</button>
        </div>

        <!-- Contenido principal -->
        <div v-if="!loading && !error" class="reports-content">

            <!-- Resumen de comportamiento -->
            <div class="behavior-summary">
                <div class="summary-card good">
                    <div class="summary-icon">
                        <i class="icon-smile">😊</i>
                    </div>
                    <div class="summary-info">
                        <h3>Reportes Positivos</h3>
                        <p class="summary-number">{{ positiveReports.length }}</p>
                    </div>
                </div>

                <div class="summary-card warning">
                    <div class="summary-icon">
                        <i class="icon-warning">⚠️</i>
                    </div>
                    <div class="summary-info">
                        <h3>Reportes Negativos</h3>
                        <p class="summary-number">{{ negativeReports.length }}</p>
                    </div>
                </div>

                <div class="summary-card info">
                    <div class="summary-icon">
                        <i class="icon-calendar">📅</i>
                    </div>
                    <div class="summary-info">
                        <h3>Total Inasistencias</h3>
                        <p class="summary-number">{{ totalAbsences }}</p>
                    </div>
                </div>
            </div>

            <!-- Sección de Inasistencias -->
            <div class="section">
                <h2 class="section-title">Reporte de Inasistencias</h2>
                <div class="absence-cards">
                    <div
                        v-for="period in periods"
                        :key="period.id"
                        class="absence-card"
                        :class="getAbsenceCardClass(getAbsencesByPeriod(period.id))"
                    >
                        <div class="absence-header">
                            <h3>{{ period.name }}</h3>
                            <span class="period-dates">
                {{ formatDate(period.start_date) }} - {{ formatDate(period.end_date) }}
              </span>
                        </div>
                        <div class="absence-count">
                            <span class="count-number">{{ getAbsencesByPeriod(period.id) }}</span>
                            <span class="count-label">Inasistencias</span>
                        </div>
                        <div class="absence-status">
              <span :class="getAbsenceStatusClass(getAbsencesByPeriod(period.id))">
                {{ getAbsenceStatusText(getAbsencesByPeriod(period.id)) }}
              </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Reportes de Conducta -->
            <div class="section">
                <h2 class="section-title">Reportes de Conducta</h2>

                <!-- Filtros -->
                <div class="filters">
                    <select v-model="selectedType" class="filter-select">
                        <option value="">Todos los tipos</option>
                        <option value="positive">Positivos</option>
                        <option value="negative">Negativos</option>
                    </select>

                    <select v-model="selectedPeriod" class="filter-select">
                        <option value="">Todos los periodos</option>
                        <option v-for="period in periods" :key="period.id" :value="period.id">
                            {{ period.name }}
                        </option>
                    </select>
                </div>

                <!-- Lista de reportes -->
                <div v-if="filteredReports.length === 0" class="no-reports">
                    <div class="no-reports-icon">📋</div>
                    <h3>No hay reportes de conducta</h3>
                    <p>¡Excelente! No tienes reportes de conducta registrados.</p>
                </div>

                <div v-else class="reports-list">
                    <div
                        v-for="report in filteredReports"
                        :key="report.id"
                        class="report-card"
                        :class="report.type"
                    >
                        <div class="report-header">
                            <div class="report-type">
                <span
                    class="type-badge"
                    :class="report.type"
                >
                  {{ report.type === 'positive' ? '✅ Positivo' : '❌ Negativo' }}
                </span>
                                <span class="report-date">{{ formatDateTime(report.created_at) }}</span>
                            </div>
                            <div class="report-period">
                                {{ getPeriodName(report.period_id) }}
                            </div>
                        </div>

                        <div class="report-content">
                            <h4 class="report-title">{{ report.title }}</h4>
                            <p class="report-description">{{ report.description }}</p>

                            <div class="report-details">
                                <div class="detail-item">
                                    <strong>Materia:</strong> {{ getSubjectName(report.subject_id) }}
                                </div>
                                <div class="detail-item" v-if="report.teacher_name">
                                    <strong>Profesor:</strong> {{ report.teacher_name }}
                                </div>
                                <div class="detail-item" v-if="report.severity">
                                    <strong>Gravedad:</strong>
                                    <span :class="'severity-' + report.severity">
                    {{ getSeverityText(report.severity) }}
                  </span>
                                </div>
                            </div>

                            <div v-if="report.actions_taken" class="actions-taken">
                                <strong>Acciones tomadas:</strong>
                                <p>{{ report.actions_taken }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de tendencias (opcional) -->
            <div class="section">
                <h2 class="section-title">Tendencia Mensual</h2>
                <div class="chart-container">
                    <div class="chart-placeholder">
                        <div class="chart-info">
                            <h4>Resumen por Periodo</h4>
                            <div class="chart-data">
                                <div v-for="period in periods" :key="period.id" class="chart-bar">
                                    <div class="bar-label">{{ period.name }}</div>
                                    <div class="bar-container">
                                        <div
                                            class="bar positive"
                                            :style="{ height: getBarHeight(getReportsByPeriod(period.id, 'positive')) + 'px' }"
                                        ></div>
                                        <div
                                            class="bar negative"
                                            :style="{ height: getBarHeight(getReportsByPeriod(period.id, 'negative')) + 'px' }"
                                        ></div>
                                    </div>
                                    <div class="bar-values">
                                        <span class="positive-count">+{{ getReportsByPeriod(period.id, 'positive') }}</span>
                                        <span class="negative-count">-{{ getReportsByPeriod(period.id, 'negative') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'StudentBehaviorReports',
    data() {
        return {
            loading: true,
            error: null,
            studentInfo: {
                id: null,
                name: '',
                lastName: '',
                enrollment: '',
                grade: '',
                group: ''
            },
            periods: [],
            subjects: [],
            behaviorReports: [],
            absences: [],
            selectedType: '',
            selectedPeriod: ''
        }
    },
    computed: {
        positiveReports() {
            return this.behaviorReports.filter(report => report.type === 'positive')
        },
        negativeReports() {
            return this.behaviorReports.filter(report => report.type === 'negative')
        },
        totalAbsences() {
            return this.absences.reduce((total, absence) => total + absence.count, 0)
        },
        filteredReports() {
            let filtered = [...this.behaviorReports]

            if (this.selectedType) {
                filtered = filtered.filter(report => report.type === this.selectedType)
            }

            if (this.selectedPeriod) {
                filtered = filtered.filter(report => report.period_id == this.selectedPeriod)
            }

            return filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        }
    },
    methods: {
        async fetchStudentInfo() {
            try {
                const studentId = this.getStudentId()
                const response = await axios.get(`/api/students/${studentId}`)
                this.studentInfo = response.data
            } catch (error) {
                console.error('Error al obtener información del estudiante:', error)
            }
        },
        async fetchReports() {
            try {
                this.loading = true
                this.error = null

                const studentId = this.getStudentId()

                // Obtener reportes de conducta
                const reportsResponse = await axios.get(`/api/students/${studentId}/behavior-reports`)
                this.behaviorReports = reportsResponse.data.reports || []
                this.periods = reportsResponse.data.periods || []
                this.subjects = reportsResponse.data.subjects || []

                // Obtener inasistencias
                const absencesResponse = await axios.get(`/api/students/${studentId}/absences`)
                this.absences = absencesResponse.data.absences || []

                this.loading = false
            } catch (error) {
                console.error('Error al obtener reportes:', error)
                this.error = 'Error al cargar los reportes. Por favor, intenta de nuevo.'
                this.loading = false
            }
        },
        getStudentId() {
            return localStorage.getItem('student_id') || 1
        },
        getAbsencesByPeriod(periodId) {
            const absence = this.absences.find(a => a.period_id === periodId)
            return absence ? absence.count : 0
        },
        getAbsenceCardClass(count) {
            if (count === 0) return 'excellent'
            if (count <= 2) return 'good'
            if (count <= 5) return 'warning'
            return 'danger'
        },
        getAbsenceStatusClass(count) {
            if (count === 0) return 'status-excellent'
            if (count <= 2) return 'status-good'
            if (count <= 5) return 'status-warning'
            return 'status-danger'
        },
        getAbsenceStatusText(count) {
            if (count === 0) return 'Excelente'
            if (count <= 2) return 'Bueno'
            if (count <= 5) return 'Regular'
            return 'Requiere atención'
        },
        getPeriodName(periodId) {
            const period = this.periods.find(p => p.id === periodId)
            return period ? period.name : 'N/A'
        },
        getSubjectName(subjectId) {
            const subject = this.subjects.find(s => s.id === subjectId)
            return subject ? subject.name : 'N/A'
        },
        getSeverityText(severity) {
            const severities = {
                low: 'Leve',
                medium: 'Moderada',
                high: 'Grave'
            }
            return severities[severity] || severity
        },
        getReportsByPeriod(periodId, type) {
            return this.behaviorReports.filter(r =>
                r.period_id === periodId && r.type === type
            ).length
        },
        getBarHeight(count) {
            const maxCount = Math.max(...this.periods.map(p =>
                Math.max(
                    this.getReportsByPeriod(p.id, 'positive'),
                    this.getReportsByPeriod(p.id, 'negative')
                )
            ))
            return maxCount > 0 ? (count / maxCount) * 100 : 0
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString('es-ES')
        },
        formatDateTime(datetime) {
            return new Date(datetime).toLocaleString('es-ES')
        }
    },
    async mounted() {
        await this.fetchStudentInfo()
        await this.fetchReports()
    }
}
</script>

<style scoped>
.behavior-reports-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.student-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.title {
    margin: 0 0 20px 0;
    font-size: 2.5rem;
    font-weight: 300;
}

.student-info h2 {
    margin: 0 0 10px 0;
    font-size: 1.8rem;
}

.student-details {
    margin: 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.loading {
    text-align: center;
    padding: 60px 20px;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.error-message {
    text-align: center;
    padding: 40px;
    background: #fee;
    border: 1px solid #fcc;
    border-radius: 8px;
    color: #c33;
}

.retry-btn {
    background: #667eea;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 10px;
}

.retry-btn:hover {
    background: #5a6fd8;
}

.behavior-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.summary-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 20px;
}

.summary-card.good {
    border-left: 5px solid #28a745;
}

.summary-card.warning {
    border-left: 5px solid #ffc107;
}

.summary-card.info {
    border-left: 5px solid #17a2b8;
}

.summary-icon {
    font-size: 2.5rem;
}

.summary-info h3 {
    margin: 0 0 10px 0;
    color: #666;
    font-size: 14px;
    text-transform: uppercase;
}

.summary-number {
    font-size: 2.5rem;
    font-weight: bold;
    margin: 0;
    color: #333;
}

.section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.section-title {
    margin: 0 0 25px 0;
    color: #333;
    font-size: 1.8rem;
    font-weight: 300;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}

.absence-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.absence-card {
    padding: 25px;
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    text-align: center;
    transition: transform 0.2s;
}

.absence-card:hover {
    transform: translateY(-2px);
}

.absence-card.excellent {
    border-color: #28a745;
    background: #f8fff9;
}

.absence-card.good {
    border-color: #17a2b8;
    background: #f8fcff;
}

.absence-card.warning {
    border-color: #ffc107;
    background: #fffdf8;
}

.absence-card.danger {
    border-color: #dc3545;
    background: #fff8f8;
}

.absence-header h3 {
    margin: 0 0 5px 0;
    color: #333;
    font-size: 1.2rem;
}

.period-dates {
    font-size: 0.9rem;
    color: #666;
}

.absence-count {
    margin: 20px 0;
}

.count-number {
    display: block;
    font-size: 3rem;
    font-weight: bold;
    color: #333;
}

.count-label {
    color: #666;
    font-size: 0.9rem;
}

.absence-status span {
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.status-excellent {
    background: #d4edda;
    color: #155724;
}

.status-good {
    background: #d1ecf1;
    color: #0c5460;
}

.status-warning {
    background: #fff3cd;
    color: #856404;
}

.status-danger {
    background: #f8d7da;
    color: #721c24;
}

.filters {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}

.filter-select {
    padding: 10px 15px;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    min-width: 200px;
}

.filter-select:focus {
    outline: none;
    border-color: #667eea;
}

.no-reports {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.no-reports-icon {
    font-size: 4rem;
    margin-bottom: 20px;
}

.no-reports h3 {
    margin: 0 0 10px 0;
    color: #333;
}

.reports-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.report-card {
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 25px;
    transition: transform 0.2s;
}

.report-card:hover {
    transform: translateY(-2px);
}

.report-card.positive {
    border-left: 5px solid #28a745;
    background: #f8fff9;
}

.report-card.negative {
    border-left: 5px solid #dc3545;
    background: #fff8f8;
}

.report-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.report-type {
    display: flex;
    align-items: center;
    gap: 15px;
}

.type-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.type-badge.positive {
    background: #d4edda;
    color: #155724;
}

.type-badge.negative {
    background: #f8d7da;
    color: #721c24;
}

.report-date {
    color: #666;
    font-size: 0.9rem;
}

.report-period {
    background: #f0f0f0;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.9rem;
    color: #666;
}

.report-title {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 1.2rem;
}

.report-description {
    color: #666;
    line-height: 1.5;
    margin-bottom: 15px;
}

.report-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 15px;
}

.detail-item {
    font-size: 0.9rem;
    color: #666;
}

.detail-item strong {
    color: #333;
}

.severity-low {
    color: #28a745;
}

.severity-medium {
    color: #ffc107;
}

.severity-high {
    color: #dc3545;
}

.actions-taken {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
}

.actions-taken strong {
    color: #333;
}

.actions-taken p {
    margin: 5px 0 0 0;
    color: #666;
}

.chart-container {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
}

.chart-info h4 {
    text-align: center;
    margin: 0 0 30px 0;
    color: #333;
}

.chart-data {
    display: flex;
    justify-content: space-around;
    align-items: end;
    height: 200px;
    gap: 20px;
}

.chart-bar {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.bar-label {
    font-size: 0.9rem;
    color: #666;
    font-weight: 500;
}

.bar-container {
    display: flex;
    gap: 5px;
    align-items: end;
    height: 120px;
}

.bar {
    width: 20px;
    border-radius: 4px 4px 0 0;
    min-height: 10px;
}

.bar.positive {
    background: #28a745;
}

.bar.negative {
    background: #dc3545;
}

.bar-values {
    display: flex;
    gap: 10px;
    font-size: 0.8rem;
}

.positive-count {
    color: #28a745;
    font-weight: 500;
}

.negative-count {
    color: #dc3545;
    font-weight: 500;
}

@media (max-width: 768px) {
    .behavior-reports-container {
        padding: 10px;
    }

    .title {
        font-size: 2rem;
    }

    .behavior-summary {
        grid-template-columns: 1fr;
    }

    .absence-cards {
        grid-template-columns: 1fr;
    }

    .filters {
        flex-direction: column;
    }

    .filter-select {
        min-width: 100%;
    }

    .report-header {
        flex-direction: column;
        align-items: start;
        gap: 10px;
    }

    .chart-data {
        flex-direction: column;
        height: auto;
        gap: 15px;
    }

    .chart-bar {
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
    }

    .bar-container {
        height: 30px;
    }
}
</style>
