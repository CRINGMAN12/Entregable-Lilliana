<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'description',
        'due_date',
        'status',
        'progress'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'progress' => 'integer'
    ];

    /**
     * Obtiene el usuario propietario del proyecto.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el curso al que pertenece el proyecto.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Obtiene las etiquetas asociadas al proyecto.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Verifica si el proyecto está vencido.
     */
    public function isOverdue(): bool
    {
        return $this->due_date->isPast() && $this->status !== 'completed';
    }

    /**
     * Verifica si el proyecto está activo.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Verifica si el proyecto está completado.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Actualiza el progreso del proyecto.
     */
    public function updateProgress(int $progress): void
    {
        $this->progress = max(0, min(100, $progress));
        
        if ($this->progress === 100) {
            $this->status = 'completed';
        }
        
        $this->save();
    }
} 