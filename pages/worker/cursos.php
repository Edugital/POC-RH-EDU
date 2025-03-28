<?php
$pageTitle = 'Meus Cursos';
ob_start();

// Mock data for courses
$courseStats = array(
    'completed' => 3,
    'total' => 5,
    'completion_rate' => 60
);

$courses = array(
    array(
        'id' => 1,
        'title' => 'Direção Defensiva',
        'hours' => 20,
        'status' => 'completed',
        'progress' => 100,
        'type' => 'mandatory',
        'completion_date' => '2024-03-15'
    ),
    array(
        'id' => 2,
        'title' => 'Segurança no Trabalho',
        'hours' => 15,
        'status' => 'in_progress',
        'progress' => 60,
        'type' => 'mandatory',
        'due_date' => '2024-04-15'
    ),
    array(
        'id' => 3,
        'title' => 'Excel Avançado',
        'hours' => 30,
        'status' => 'pending',
        'progress' => 0,
        'type' => 'optional'
    )
);
?>

<div class="courses-container">
    <!-- Progress Overview -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title">Progresso Geral</h5>
                    <div class="progress mb-2" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $courseStats['completion_rate']; ?>%"></div>
                    </div>
                    <p class="mb-0"><?php echo $courseStats['completed']; ?> de <?php echo $courseStats['total']; ?> cursos concluídos</p>
                </div>
                <div class="col-md-6">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="course-stat">
                                <h6>Concluídos</h6>
                                <span class="stat-value text-success">3</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="course-stat">
                                <h6>Em Andamento</h6>
                                <span class="stat-value text-warning">1</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="course-stat">
                                <h6>Pendentes</h6>
                                <span class="stat-value text-danger">1</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" data-filter="all">Todos</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="mandatory">Obrigatórios</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="optional">Opcionais</button>
                </div>
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Buscar cursos...">
                </div>
            </div>
        </div>
    </div>

    <!-- Course List -->
    <div class="row g-4">
        <?php foreach ($courses as $course): ?>
        <div class="col-md-6 col-lg-4" data-course-type="<?php echo $course['type']; ?>">
            <div class="card h-100 course-card">
                <div class="card-body">
                    <div class="course-status-badge <?php echo $course['status']; ?>">
                        <?php
                        switch($course['status']) {
                            case 'completed':
                                echo '<i class="fas fa-check-circle"></i> Concluído';
                                break;
                            case 'in_progress':
                                echo '<i class="fas fa-clock"></i> Em Andamento';
                                break;
                            default:
                                echo '<i class="fas fa-circle"></i> Pendente';
                        }
                        ?>
                    </div>
                    <h5 class="card-title mb-3"><?php echo htmlspecialchars($course['title']); ?></h5>
                    <div class="course-info mb-3">
                        <span><i class="fas fa-clock text-muted"></i> <?php echo $course['hours']; ?>h</span>
                        <?php if ($course['type'] == 'mandatory'): ?>
                        <span class="mandatory-badge"><i class="fas fa-exclamation-circle"></i> Obrigatório</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($course['status'] != 'pending'): ?>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $course['progress']; ?>%"></div>
                    </div>
                    <?php endif; ?>
                    <div class="course-actions">
                        <?php if ($course['status'] == 'completed'): ?>
                            <button class="btn btn-outline-success btn-sm" onclick="viewCertificate(<?php echo $course['id']; ?>)">
                                <i class="fas fa-award"></i> Ver Certificado
                            </button>
                        <?php elseif ($course['status'] == 'in_progress'): ?>
                            <button class="btn btn-primary btn-sm" onclick="continueCourse(<?php echo $course['id']; ?>)">
                                <i class="fas fa-play"></i> Continuar
                            </button>
                        <?php else: ?>
                            <button class="btn btn-primary btn-sm" onclick="startCourse(<?php echo $course['id']; ?>)">
                                <i class="fas fa-play"></i> Iniciar
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Supplementary Materials -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Materiais Complementares</h5>
        </div>
        <div class="card-body">
            <div class="materials-list">
                <div class="material-item">
                    <i class="fas fa-file-pdf"></i>
                    <span>Manual do Motorista.pdf</span>
                    <button class="btn btn-link btn-sm" onclick="downloadMaterial('manual.pdf')">
                        <i class="fas fa-download"></i> Download
                    </button>
                </div>
                <div class="material-item">
                    <i class="fas fa-file-video"></i>
                    <span>Vídeo Institucional.mp4</span>
                    <button class="btn btn-link btn-sm" onclick="downloadMaterial('video.mp4')">
                        <i class="fas fa-download"></i> Download
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.course-card {
    position: relative;
    transition: transform 0.2s;
}

.course-card:hover {
    transform: translateY(-2px);
}

.course-status-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.course-status-badge.completed {
    background-color: #d4edda;
    color: #155724;
}

.course-status-badge.in_progress {
    background-color: #fff3cd;
    color: #856404;
}

.course-status-badge.pending {
    background-color: #e9ecef;
    color: #495057;
}

.course-info {
    display: flex;
    gap: 1rem;
    color: #6c757d;
    font-size: 0.875rem;
}

.mandatory-badge {
    color: #dc3545;
}

.course-stat {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.course-stat h6 {
    margin: 0 0 0.5rem 0;
    font-size: 0.875rem;
    color: #6c757d;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 600;
}

.materials-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.material-item {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.material-item i {
    font-size: 1.25rem;
    color: #6c757d;
    margin-right: 1rem;
}

.material-item span {
    flex: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('[data-filter]');
    const courseCards = document.querySelectorAll('[data-course-type]');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Filter courses
            courseCards.forEach(card => {
                if (filter === 'all' || card.dataset.courseType === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    searchInput?.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        courseCards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            if (title.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// Course action functions
function viewCertificate(courseId) {
    alert('Visualizando certificado do curso ' + courseId);
}

function continueCourse(courseId) {
    alert('Continuando curso ' + courseId);
}

function startCourse(courseId) {
    alert('Iniciando curso ' + courseId);
}

function downloadMaterial(filename) {
    alert('Baixando material: ' + filename);
}
</script>

<?php
$content = ob_get_clean();
require_once 'template.php';
?> 