 {{-- Add content to subcategories --}}
 <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Gestion des sous-categories</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         <form action='{{ route('addToSub') }}' method="post">
             {{ csrf_field() }}
             <div class="modal-body">
                 <label>Catégorie</label>
                 <select required name="category" class="form-control SlectBox"
                     onclick="console.log($(this).val())" onchange="console.log('change is firing')">
                     <!--placeholder-->
                     <option value="" selected disabled>Choisissez une catégorie</option>
                     @foreach ($categories as $category)
                         <option value="{{ $category->id }}"> {{ $category->name }}</option>
                     @endforeach
                 </select>
                 <br>
                 <label for="inputName" class="control-label">Sous-Categorie</label>
                 <select required id="subcategory" name="subcategory" class="form-control">
                 </select>
                 <br>
                 <label>Formations</label>
                 <select name="formation" class="form-control SlectBox">
                     <!--placeholder-->
                     <option value="" selected disabled>Choisissez une formation</option>
                     @foreach ($formations as $formation)
                         <option value="{{ $formation->id }}"> {{ $formation->name }}</option>
                     @endforeach
                 </select>
                 <br>
                 <label>Machines</label>
                 <select name="machine" class="form-control SlectBox">
                     <!--placeholder-->
                     <option value="" selected disabled>Choisissez une machine</option>
                     @foreach ($machines as $machine)
                         <option value="{{ $machine->id }}"> {{ $machine->name }}</option>
                     @endforeach
                 </select>

                 <label>Matières premières</label>
                 <select name="material" class="form-control SlectBox">
                     <!--placeholder-->
                     <option value="" selected disabled>Choisissez une matière première</option>
                     @foreach ($materials as $material)
                         <option value="{{ $material->id }}"> {{ $material->name }}</option>
                     @endforeach
                 </select>


                 <div class="modal-footer">
                     <button type="submit" class="btn btn-primary"
                         style="background-color: #FF3636">Confirmer</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                 </div>
         </form>
     </div>
 </div>
</div>
