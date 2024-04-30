<div class="col">
    <label for="first_name" class="form-label">First name*</label>
    <input type="text" class="form-control" name="first_name" required>
    @error('first_name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="col">
    <label for="last_name" class="form-label">Last name</label>
    <input type="text" class="form-control" name="last_name">
</div>
<div class="col-12">
    <label for="email" class="form-label">Email</label>
    <input type="text" class="form-control" name="email">
    @error('email')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="col-12">
    <button class="btn btn-primary" type="submit">Submit form</button>
</div>