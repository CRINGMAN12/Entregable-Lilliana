<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'description',
        'start_date',
        'due_date',
        'priority',
        'status'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'start_date' => 'datetime'
    ];

    /**
     * Obtiene el usuario propietario de la tarea.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el curso al que pertenece la tarea.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Obtiene las etiquetas asociadas a la tarea.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Verifica si la tarea está vencida.
     */
    public function isOverdue(): bool
    {
        return $this->due_date->isPast() && $this->status !== 'completed';
    }

    /**
     * Verifica si la tarea está pendiente.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Verifica si la tarea está completada.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
} 