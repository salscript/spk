<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder"><?= $title ?></h3>
            </div>
            <div class="col-sm-6">
               <div class="row">
                  <div class="col-11">
                     <button class="btn btn-primary text-sm float-right mr-2" onclick="cancel()">Cancel</button>
                  </div>
                  <div class="col-1">
                     <button class="btn btn-outline-primary text-sm float-right" onclick="reload()">
                        <i class="fas fa-sync"></i>
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <section class="content">
      <div class="container-fluid">
         <div class="row mt-2">
            <div class="col-12">
               <div class="card">
                  <div class="card-body table-responsive text-sm">
                    <h5 class="mb-3">Menilai untuk <?= $evaluatee->fullname ?></h5>
                    <hr>
                    <?php 
                     $evaluator_position = $this->session->userdata('position');
                     $evaluatee_position = $evaluatee->position_name;
                     $form_action = ($evaluator_position === $evaluatee_position) ? site_url('questioner/submit_peer'): site_url('questioner/submit_supervisor');
                    ?>
                    <form action="<?= $form_action ?>" method="POST">
                     <input type="hidden" name="questioner_id" value="<?= $questioner_id ?>">
                     <input type="hidden" name="evaluatee_id" value="<?= $evaluatee->id ?>">

                     <?php
                     $grouped = []; 
                     foreach ($questions as $q) {
                        $grouped[$q->criteria_name][] = $q;
                     }

                        $options = [
                           1 => '1 - Sangat Tidak Setuju',
                           2 => '2 - Tidak Setuju',
                           3 => '3 - Netral',
                           4 => '4 - Setuju',
                           5 => '5 - Sangat Setuju',
                        ];
                     ?>

                     <?php foreach ($grouped as $criteria_name => $questions_group): ?>
                        <div class="card mb-3">
                              <div class="card-header bg-primary text-white font-weight-bold">
                                 <?= $criteria_name ?>
                              </div>
                              <div class="card-body">
                                 <?php foreach ($questions_group as $q): ?>
                                    <div class="form-group">
                                          <label><?= $q->question_text ?></label>
                                          <div>
                                             <?php foreach ($options as $value => $label): ?>
                                                <div class="form-check form-check-inline">
                                                      <input
                                                         class="form-check-input"
                                                         type="radio"
                                                         name="answers[<?= $q->id ?>]"
                                                         id="answer_<?= $q->id ?>_<?= $value ?>"
                                                         value="<?= $value ?>"
                                                         required
                                                      >
                                                      <label class="form-check-label" for="answer_<?= $q->id ?>_<?= $value ?>">
                                                         <?= $label ?>
                                                      </label>
                                                </div>
                                             <?php endforeach; ?>
                                          </div>
                                    </div>
                                 <?php endforeach; ?>
                              </div>
                        </div>
                     <?php endforeach; ?>

                     <button type="submit" class="btn btn-success">Kirim Penilaian</button>
                     <!-- <a href="<?= site_url('questioner') ?>" class="btn btn-secondary">Batal</a> -->
                  </form>
                 </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
<script type="text/javascript">
   function cancel() {
      window.location.href = "<?= base_url('questioner/index/'). $questioner_id ?>";
   }

   function reload() {
      location.reload();
   }
</script>
