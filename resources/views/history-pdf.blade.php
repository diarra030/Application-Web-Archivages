<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des activités</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .activity-list {
            margin: 20px 0;
        }

        .activity-item {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-action {
            font-weight: bold;
            color: #2d3748;
        }

        .activity-description {
            color: #4a5568;
        }

        .activity-meta {
            font-size: 0.875rem;
            color: #718096;
        }
    </style>
</head>

<body>
    <h1>Historique des activités</h1>
    <div class="activity-list">
        @if (count($activities) > 0)
            @foreach ($activities as $activity)
                <div class="activity-item">
                    <p>
                        <span class="activity-action">{{ $activity->action }}</span> :
                        <span class="activity-description">{{ $activity->description }}</span>
                    </p>
                    <p class="activity-meta">
                        Par {{ $activity->user ? $activity->user->name : 'Utilisateur supprimé' }} -
                        {{ $activity->created_at->diffForHumans() }}
                    </p>
                </div>
            @endforeach
        @else
            <p>Aucune activité récente</p>
        @endif
    </div>
</body>

</html>
