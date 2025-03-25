<div class="container">
		<h1 class="mb-4" id="h1-editProfile">Edit Profile</h1>
		<div class="main-body">
			<div class="row">
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body">
							<div class="d-flex flex-column align-items-center text-center">
								<div id="profile-container">
									<!--<img src=<?php echo "/assets/img/userPictures/profile_{$_SESSION['profilePicture']}.jpeg" ?> alt="Profile Image" class="rounded-circle p-1 bg-primary" id="profileImage" width="110">-->
									<img src="../../assets/img/profileEdit/defaultProfilePic.jpg" alt="Profile Image" class="rounded-circle p-1 bg-primary" id="profileImage" width="110">
									<!--<label for="profile_photo" class="form-label">Profile Image</label>
                					<input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">-->
								</div>
								<!--<button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#profilePictureModal">
									Change Profile Picture
								</button>-->
								<div class="mt-3">
									<h4><?php echo $user['FullName']; ?></h4>
									<p class="text-muted font-size-sm">Role: <?php echo $user['Role']; ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-8">
					<div class="card">
						<form action="/profile/update/name" method="post">
							<div class="card-body">
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Full Name</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="text" class="form-control editForm" id="fullName" name="fullName" value="<?php echo $user['FullName'];?>" required minlength="5" maxlength="20">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3"></div>
									<div class="col-sm-9 text-secondary">
										<input type="button" id="openPrompt1" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modal-name" value="Save Changes">
									</div>
									<?php if (!empty($nameValidation)): ?>
										<p style="color: red"><?= $nameValidation ?></p>
										<?endif; ?>
								</div>
									<!-- Modal Name Change-->
								<div class="modal fade" tabindex="-1" id="modal-name">
									<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Name change</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<p id="name-change">You are about to change your name.</p>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
											<input type="submit" class="btn btn-primary" value="Save Changes"></input>
										</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>

					<div class="col-lg-8">
						<div class="card">
							<form action="/profile/update/email" method="post">
								<div class="card-body">
									<div class="row mb-3">
										<div class="col-sm-3">
											<h6 class="mb-0">Current Email</h6>
										</div>
										<div class="col-sm-9 text-secondary">
											<input type="email" class="form-control editForm" id="currentEmail" name="currentEmail" value="<?php echo $user['Email'];?>" required>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col-sm-3">
											<h6 class="mb-0">New Email</h6>
										</div>
										<div class="col-sm-9 text-secondary">
											<input type="email" class="form-control editForm" id="newEmail" name="newEmail" required>
										</div>
									</div>
									<div class="row mb-3">
										<div class="col-sm-3">
											<h6 class="mb-0">Confirm Email</h6>
										</div>
										<div class="col-sm-9 text-secondary">
											<input type="email" class="form-control editForm" id="confirmEmail" name="confirmEmail" required>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3"></div>
										<div class="col-sm-9 text-secondary">
											<input type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modal-email" value="Save Changes">
										</div>
										<?php if (!empty($emailValidation)): ?>
										<p style="color: red"><?= $emailValidation ?></p>
										<?endif; ?>
									</div>
									<!-- Modal Email Change-->
									<div class="modal fade" tabindex="-1" id="modal-email">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title">Email Change</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													<p id="email-change">You are about to change your email.</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
													<input type="submit" class="btn btn-primary" value="Confirm Change"></input>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>


					<div class="col-lg-8">
                        <div class="card">
							<form action="/profile/update/password" method="post">
								<div class="card-body">
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Current Password</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="password" class="form-control" id="inpCurrentPsw" name="inpCurrentPsw" required minlength="5">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">New Password</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="password" class="form-control" id="inpNewPsw" name="inpNewPsw" required minlength="5">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Repeat New Password</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input type="password" class="form-control" id="inpRepeatNewPsw" name="inpRepeatNewPsw" required minlength="5">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-12 text-right">
										<button type="button" id="toggleAllPasswords" class="btn btn-sm btn-secondary">Show/Hide All</button>
									</div>
								</div>
									<div class="row">
										<div class="col-sm-3"></div>
										<div class="col-sm-9 text-secondary">
										<input type="button" class="btn btn-primary px-4" id="openPrompt2" data-bs-toggle="modal" data-bs-target="#modal-pswd" value="Change Password">
										</div>
										<?php if (!empty($passwordValidation)): ?>
										<p style="color: red"><?= $passwordValidation ?></p>
										<?endif; ?>
									</div>
										<!-- Modal Password change -->
									<div class="modal fade" tabindex="-1" id="modal-pswd">
										<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Password change</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<p>You are about to change you Password.</p>
												<p>Make sure to not forget it!</p>
												<p>You will be required to log in again!</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
												<input type="submit" class="btn btn-primary" value="Change Password"></input>
											</div>
											</div>
										</div>
									</div>
								</div>
							</form>
                        </div>
					</div>

			</div>
			<!-- Modal for profile picture selection -->
			<div class="modal fade" id="profilePictureModal" tabindex="-1" aria-labelledby="profilePictureModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<form action="/profile/updateImage" method="post" id="profilePicForm">
							<div class="modal-header">
								<h5 class="modal-title" id="profilePictureModalLabel">Choose a Profile Picture</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="d-flex flex-wrap justify-content-center">
									<?php for ($i = 1; $i <= 10; $i++): ?>
										<img src="/assets/img/userPictures/profile_<?= $i ?>.jpeg" class="profile-pic m-2" value="<?= $i ?>" alt="Profile Picture <?= $i ?>">
									<?php endfor; ?>
								</div>
							</div>
							<input type="hidden" name="selectedPicIndex" id="selectedPicIndex" value="">
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>