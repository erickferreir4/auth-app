<main>
    <div class="login">
        <div class="login--center">
            <h2>Login</h2>
    
            <form action="/login" method="POST">
                <input type="email" placeholder="Email" name="email" />
                <input type="password" name="passwd" placeholder="Password" />
    
                <button type="submit">Login</button>
            </form>
    
            <p>or continue with these social profile</p>
            
            <ul>
                <li><button><img src="/assets/imgs/Google.svg" /></button></li>
                <li><button><img src="/assets/imgs/Facebook.svg" /></button></li>
                <li><button><img src="/assets/imgs/Twitter.svg" /></button></li>
                <li><button><img src="/assets/imgs/Github.svg" /></button></li>
            </ul>

            <p>Don’t have an account yet? <a href="/register">Register</a></p>
        </div>
    </div>
</main>
