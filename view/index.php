<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Weather App</title>
</head>
<body>
<div class="container d-flex flex-column align-items-center">
    <h1>Weather App greetings you!</h1>
    <?php if (!empty($model)): ?>
    <div class="card mb-3" style="width: 400px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= $model->icon ?>" class="card-img" alt="<?= $model->description ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $model->city ?></h5>
                    <p class="card-text"><em><?= $model->description ?></em></p>
                    <p class="card-text">Температура: <?= $model->temp ?> &deg;C</p>
                    <p class="card-text">Давление: <?= $model->pressure ?> мм.рт.с.</p>
                    <p class="card-text">Влажность: <?= $model->humidity ?> %</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Последнее обновление: <?= date('H:i:s d.m.Y', $model->updated_at) ?></small>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
        <div class="form-group">
            <label for="provider">Поставщик данных</label>
            <select class="form-control" id="provider" name="provider" required>
                <option value="" disabled selected>Выберите поставщика</option>
                <option value="\app\model\OpenWeatherDataProvider">OpenWeather</option>
                <option value="\app\model\AccuWeatherDataProvider">AccuWeather</option>
            </select>
        </div>
        <div class="form-group">
            <label for="city">Город</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Город" required>
        </div>
        <button type="submit" class="btn btn-info">Показать</button>
    </form>
</div>
</body>
</html>