<main>
    <div class="register">
        <div class="register--center">
            <h2>Join thousands of learners from around the world </h2>

            <h3>Master web development by making real-life projects. There are multiple paths for you to choose</h3>
    
            <p class="<?= $this->userExists ? 'is--active' : ''?>">user exists</p>
            <form action="/register" method="POST" onsubmit="return passwdConf();">
                <input type="email" placeholder="Email" name="email"/>
                <input type="password" placeholder="Password" name="passwd"/>
                <input type="password" placeholder="Confirm Password" name="conf-passwd"/>
    
                <button type="submit">Start coding now</button>
            </form>
    
            <p>or continue with these social profile</p>
            
            <ul>
                <li><button><img src="/assets/imgs/Google.svg" /></button></li>
                <li><button><img src="/assets/imgs/Facebook.svg" /></button></li>
                <li><button><img src="/assets/imgs/Twitter.svg" /></button></li>
                <li><button><img src="/assets/imgs/Github.svg" /></button></li>
            </ul>

            <p>Adready a member? <a href="/login">Login</a></p>
        </div>
    </div>
</main>

