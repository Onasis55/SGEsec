<template>
    <div class="student-grades-container">
        <!-- Header del estudiante -->
        <div class="student-header">
            <h1 class="title">Mis Calificaciones</h1>
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
            <p>Cargando calificaciones...</p>
        </div>

        <!-- Error state -->
        <div v-if="error" class="error-message">
            <p>{{ error }}</p>
            <button @click="fetchGrades" class="retry-btn">Reintentar</button>
        </div>

        <!-- Tabla de calificaciones -->
        <div v-if="!loading && !error" class="grades-section">
            <div class="table-container">
                <table class="grades-table">
                    <thead>
                    <tr>
                        <th class="subject-header">Materia</th>
                        <th v-for="period in periods" :key="period.id" class="period-header">
                            {{ period.name }}
                        </th>
                        <th class="average-header">Promedio</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="subject in subjects" :key="subject.id" class="subject-row">
                        <td class="subject-name">{{ subject.name }}</td>
                        <td v-for="period in periods" :key="period.id" class="grade-cell">
                <span
                    :class="getGradeClass(getGrade(subject.id, period.id))"
                    class="grade-value"
                >
                  {{ getGrade(subject.id, period.id) || '--' }}
                </span>
                        </td>
                        <td class="average-cell">
                <span
                    :class="getGradeClass(getSubjectAverage(subject.id))"
                    class="average-value"
                >
                  {{ getSubjectAverage(subject.id).toFixed(1) }}
                </span>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr class="totals-row">
                        <td class="totals-label"><strong>Promedio General</strong></td>
                        <td v-for="period in periods" :key="period.id" class="period-average">
                            <strong>{{ getPeriodAverage(period.id).toFixed(1) }}</strong>
                        </td>
                        <td class="general-average">
                            <strong
                                :class="getGradeClass(generalAverage)"
                                class="general-average-value"
                            >
                                {{ generalAverage.toFixed(1) }}
                            </strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Estadísticas adicionales -->
            <div class="stats-section">
                <div class="stat-card">
                    <h3>Materias Aprobadas</h3>
                    <p class="stat-number">{{ approvedSubjects }}/{{ subjects.length }}</p>
                </div>
                <div class="stat-card">
                    <h3>Mejor Materia</h3>
                    <p class="stat-text">{{ bestSubject.name }}</p>
                    <p class="stat-number">{{ bestSubject.average.toFixed(1) }}</p>
                </div>
                <div class="stat-card">
                    <h3>Materia a Mejorar</h3>
                    <p class="stat-text">{{ worstSubject.name }}</p>
                    <p class="stat-number">{{ worstSubject.average.toFixed(1) }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'StudentGradesView',
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
            subjects: [
                { id: 1, name: 'Matemáticas' },
                { id: 2, name: 'Español' },
                { id: 3, name: 'Ciencias Naturales' },
                { id: 4, name: 'Historia' },
                { id: 5, name: 'Geografía' },
                { id: 6, name: 'Educación Física' }
            ],
            periods: [
                { id: 1, name: '1er Periodo' },
                { id: 2, name: '2do Periodo' },
                { id: 3, name: '3er Periodo' }
            ],
            grades: [] // Array que contendrá las calificaciones desde Laravel
        }
    },
    computed: {
        generalAverage() {
            if (this.grades.length === 0) return 0

            const totalGrades = this.grades.filter(grade => grade.value !== null)
            if (totalGrades.length === 0) return 0

            const sum = totalGrades.reduce((acc, grade) => acc + grade.value, 0)
            return sum / totalGrades.length
        },
        approvedSubjects() {
            return this.subjects.filter(subject => this.getSubjectAverage(subject.id) >= 6).length
        },
        bestSubject() {
            let best = { name: 'N/A', average: 0 }
            this.subjects.forEach(subject => {
                const average = this.getSubjectAverage(subject.id)
                if (average > best.average) {
                    best = { name: subject.name, average }
                }
            })
            return best
        },
        worstSubject() {
            let worst = { name: 'N/A', average: 10 }
            this.subjects.forEach(subject => {
                const average = this.getSubjectAverage(subject.id)
                if (average > 0 && average < worst.average) {
                    worst = { name: subject.name, average }
                }
            })
            return worst
        }
    },
    methods: {
        async fetchStudentInfo() {
            try {
                // Obtener ID del estudiante desde el token o localStorage
                const studentId = this.getStudentId()
                const response = await axios.get(`/api/students/${studentId}`)
                this.studentInfo = response.data
            } catch (error) {
                console.error('Error al obtener información del estudiante:', error)
                this.error = 'Error al cargar la información del estudiante'
            }
        },
        async fetchGrades() {
            try {
                this.loading = true
                this.error = null

                const studentId = this.getStudentId()
                const response = await axios.get(`/api/students/${studentId}/grades`)

                this.grades = response.data.grades || []

                this.loading = false
            } catch (error) {
                console.error('Error al obtener calificaciones:', error)
                this.error = 'Error al cargar las calificaciones. Por favor, intenta de nuevo.'
                this.loading = false
            }
        },
        getStudentId() {
            // Aquí puedes obtener el ID del estudiante desde:
            // - Vue Router params: this.$route.params.id
            // - localStorage: localStorage.getItem('student_id')
            // - JWT token decodificado
            // - Vuex store
            return localStorage.getItem('student_id') || 1 // Valor por defecto para pruebas
        },
        getGrade(subjectId, periodId) {
            const grade = this.grades.find(g =>
                g.subject_id === subjectId && g.period_id === periodId
            )
            return grade ? grade.value : null
        },
        getSubjectAverage(subjectId) {
            const subjectGrades = this.grades.filter(g =>
                g.subject_id === subjectId && g.value !== null
            )

            if (subjectGrades.length === 0) return 0

            const sum = subjectGrades.reduce((acc, grade) => acc + grade.value, 0)
            return sum / subjectGrades.length
        },
        getPeriodAverage(periodId) {
            const periodGrades = this.grades.filter(g =>
                g.period_id === periodId && g.value !== null
            )

            if (periodGrades.length === 0) return 0

            const sum = periodGrades.reduce((acc, grade) => acc + grade.value, 0)
            return sum / periodGrades.length
        },
        getGradeClass(grade) {
            if (grade >= 9) return 'excellent'
            if (grade >= 8) return 'good'
            if (grade >= 7) return 'regular'
            if (grade >= 6) return 'passing'
            return 'failing'
        }
    },
    async mounted() {
        await this.fetchStudentInfo()
        await this.fetchGrades()
    }
}
</script>

<style scoped>
.student-grades-container {
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

.grades-section {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.table-container {
    overflow-x: auto;
}

.grades-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.grades-table th,
.grades-table td {
    padding: 15px 12px;
    text-align: center;
    border-bottom: 1px solid #eee;
}

.grades-table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #555;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.subject-header {
    text-align: left !important;
    min-width: 200px;
}

.subject-name {
    text-align: left !important;
    font-weight: 500;
    color: #333;
}

.grade-value,
.average-value {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    min-width: 40px;
}

.excellent {
    background: #d4edda;
    color: #155724;
}

.good {
    background: #cce6ff;
    color: #0066cc;
}

.regular {
    background: #fff3cd;
    color: #856404;
}

.passing {
    background: #ffeaa7;
    color: #6c5700;
}

.failing {
    background: #f8d7da;
    color: #721c24;
}

.totals-row {
    background: #f8f9fa;
    font-weight: bold;
}

.general-average-value {
    font-size: 16px;
}

.stats-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 30px;
    background: #f8f9fa;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.stat-card h3 {
    margin: 0 0 15px 0;
    color: #666;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #667eea;
    margin: 0;
}

.stat-text {
    font-weight: 500;
    color: #333;
    margin: 0 0 5px 0;
}

@media (max-width: 768px) {
    .student-grades-container {
        padding: 10px;
    }

    .title {
        font-size: 2rem;
    }

    .grades-table {
        font-size: 12px;
    }

    .grades-table th,
    .grades-table td {
        padding: 10px 8px;
    }

    .stats-section {
        grid-template-columns: 1fr;
        padding: 20px;
    }
}
</style>
