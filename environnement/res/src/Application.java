import javax.swing.*;

import java.awt.*;

class Application {
    private JFrame fenetre;
    private JLabel affichage;
    private JLabel affichage2;
    private JTextField champA;
    private JPasswordField champB;
    private JButton Valider;
  private JButton annuler;

    public Application() {
      this.fenetre = new JFrame("LemZoun"); 
      this.affichage = new JLabel("Email");
      this.champA = new JTextField(10); 
      
      this.affichage2 = new JLabel("Password");
      this.champB = new JPasswordField(10);
      
      this.Valider = new JButton("Valider");
      this.annuler = new JButton("Annuler");

      
     Client cl = new Client("LemZoun",this); 
      this.Valider.addActionListener(cl);
      
      GestionQuitter quiter = new GestionQuitter(); 
      this.annuler.addActionListener(quiter);
      
      Container conteneur = fenetre.getContentPane();
      GridLayout disposition = new GridLayout(3, 2);
      conteneur.setLayout(disposition);
      conteneur.add(this.affichage);
      conteneur.add(this.champA);
      conteneur.add(this.affichage2);
      conteneur.add(this.champB);
      conteneur.add(this.Valider);
      conteneur.add(this.annuler);

      this.fenetre.pack();
      this.fenetre.setVisible(true);
    }

  public String contenuChampA() {
    return this.champA.getText();
  }
  
  public char[] contenuChampB() {
    return this.champB.getPassword();
  }
  
  public void afficher(String texte) {
    this.affichage.setText(texte);
    this.fenetre.dispose();
  }
  public void fermer()
  {
	    this.fenetre.dispose();
  }
  public void annuler()
  {
	  System.exit(0);
  }
}
