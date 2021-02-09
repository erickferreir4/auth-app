<main>
<?= $this->accountTop() ?>

<section>
    <div class="edit">

        <div class="edit--center">

        <a href="/">Back</a>

        <div class="edit--info">
            <h3>Change Info</h3>
            <p>Changes will be reflected to every services</p>

            <span>
                <img src="/assets/imgs/img.png" alt="user"/>
                <button>CHANGE PHOTO</button>
            </span>

            <form>
                <label>Name</label>
                <input type="text" placeholder="Enter your name..."/>

                <label>Bio</label>
                <textarea name="textarea" rows="5" cols="50" placeholder="Enter your bio..."></textarea>

                <label>Phone</label>
                <input type="text" placeholder="Enter your phone..."/>
                
                <label>Email</label>
                <input type="text" placeholder="Enter your email..."/>

                <label>Password</label>
                <input type="text" placeholder="Enter your new password..."/>

                <button type="submit">Save</button>
            </form>
        </div>
        </div>
    </div>
    
</section>
    
</main>
