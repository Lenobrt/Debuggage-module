<?php
template('header', array(
    'title' => 'Boite à outils • Devise',
));
$url = 'https://open.er-api.com/v6/latest/EUR';

$data = file_get_contents($url);
$data = json_decode($data, true);


if ($data && isset($data['rates'])) {
    $available_currencies = array_keys($data['rates']);
    $select_options = '';
    foreach ($available_currencies as $currency) {
        $select_options .= '<option value="' . $currency . '">' . $currency . '</option>';
    }
} else {
    $select_options = '<option value="">Erreur de récupération des données</option>';
}

?>
    <!-- ======= About Section ======= -->
    <section id="homepage" class="homepage">
        <div class="container">
            <div class="section-title">
                <h2>Convertisseur de devise</h2>
            </div>

            <div class="row">
                <fieldset class="col-12 mt-4">
                    <legend>Conversion de devise</legend>
                    <form action="" method="post" name="currency-converter">
                        <div class="form-group row">
                            <div class="col">
                                <label for="amount" aria-hidden="true" hidden>Montant</label>
                                <input id="amount" name="amount" type="number" class="form-control" required>
                            </div>

                            <div class="col">
                                <label for="from_currency" aria-hidden="true" hidden>Devises</label>
                                <select id="from_currency" name="from_currency" class="form-control" required>
                                    <?php echo $select_options; ?>
                                </select>
                            </div>

                            <div class="col">
                                <label for="to_currency" aria-hidden="true" hidden>En</label>
                                <select id="to_currency" name="to_currency" class="form-control" required>
                                    <?php echo $select_options; ?>
                                </select>
                            </div>

                            <div class="col">
                                <label for="result" aria-hidden="true" hidden>Résultat</label>
                                <input id="result" name="result" type="number" class="form-control" readonly>
                            </div>

                            <div class="col-2">
                                <button name="submit" type="submit" class="btn btn-primary btn-block">Convertir</button>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </section>


    <script type="text/javascript">
        window.addEventListener('load', () => {
            let forms = document.forms;

            for(form of forms){
                form.addEventListener('submit', async (event) => {
                    event.preventDefault();

                    const formData = new FormData(event.target).entries()
                    console.log(Object.assign(Object.fromEntries(formData), {form: event.target.name}));
                    const response = await fetch('/api/post', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(
                            Object.assign(Object.fromEntries(formData), {form: event.target.name})
                        )
                    });

                    const result = await response.json();
                    

                    // let inputName = Object.keys(result.data)[0];
                    console.log(result);
                    // event.target.querySelector(`input[id="${inputName}2"]`).value = result.data[inputName];
                    event.target.querySelector(`input[id="result"]`).value = result.data.amount;
                    
                })
            }
        });
    </script>

<?php template('footer');