
<h2>Bienvenue dans le framework</h2>
<p>Bonjour <?= $name; ?></p>
{% if($bam != null){ %}
<p>Coucou</p>
{% } %}

<form method="post" action="#">
    <input type="text" name="name">
    <input type="text" name="description">
    <input type="number" name="price">

    <button type="submit">
        OK CHEF
    </button>
</form>
